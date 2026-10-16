<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SaasPaymentLog;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class SuperAdminPaymentController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');
        $gateway = $request->input('gateway', 'all');

        $query = SaasPaymentLog::with('tenant')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'ILIKE', "%{$search}%")
                  ->orWhere('transaction_id', 'ILIKE', "%{$search}%")
                  ->orWhere('payer_name', 'ILIKE', "%{$search}%")
                  ->orWhere('payer_email', 'ILIKE', "%{$search}%")
                  ->orWhereHas('tenant', function ($tq) use ($search) {
                      $tq->where('name', 'ILIKE', "%{$search}%")
                         ->orWhere('slug', 'ILIKE', "%{$search}%");
                  });
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($gateway && $gateway !== 'all') {
            $query->where('gateway', $gateway);
        }

        $payments = $query->paginate(15)->through(function ($p) {
            return [
                'id' => $p->id,
                'order_id' => $p->order_id ?? ('ORD-' . substr($p->id, 0, 8)),
                'tenant_id' => $p->tenant_id,
                'tenant_name' => $p->tenant?->name ?? 'Clínica no asignada',
                'tenant_slug' => $p->tenant?->slug ?? '',
                'amount' => (float) $p->amount,
                'currency' => $p->currency ?? 'COP',
                'gateway' => $p->gateway ?? 'bold',
                'plan_tier' => $p->plan_tier ?? 'pro',
                'status' => $p->status ?? 'approved',
                'transaction_id' => $p->transaction_id,
                'payer_name' => $p->payer_name,
                'payer_email' => $p->payer_email,
                'payer_phone' => $p->payer_phone,
                'period_start' => $p->period_start ? $p->period_start->format('d/m/Y') : null,
                'period_end' => $p->period_end ? $p->period_end->format('d/m/Y') : null,
                'notes' => $p->notes,
                'paid_at' => $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : null,
                'created_at' => $p->created_at ? $p->created_at->format('d/m/Y H:i') : null,
            ];
        });

        // Compute KPIs from real database
        $totalRecaudado = (float) SaasPaymentLog::where('status', 'approved')->sum('amount');
        $aprobadosCount = SaasPaymentLog::where('status', 'approved')->count();
        $pendientesCount = SaasPaymentLog::where('status', 'pending')->count();
        $pendientesMonto = (float) SaasPaymentLog::where('status', 'pending')->sum('amount');

        // Platform MRR
        $mrr = (float) Tenant::all()->sum(function ($t) {
            return (float) ($t->branding['saas_monthly_fee'] ?? 99000);
        });
        if ($mrr <= 0) $mrr = 198000;

        $allTenants = Tenant::select('id', 'name', 'slug')->orderBy('name')->get();
        $authUser = auth()->user();

        return Inertia::render('SuperAdmin/Payments', [
            'payments' => $payments,
            'filters' => [
                'search' => $search ?? '',
                'status' => $status,
                'gateway' => $gateway,
            ],
            'stats' => [
                'totalRecaudado' => $totalRecaudado,
                'aprobadosCount' => $aprobadosCount,
                'pendientesCount' => $pendientesCount,
                'pendientesMonto' => $pendientesMonto,
                'mrr' => $mrr,
            ],
            'tenantsList' => $allTenants,
            'userName' => $authUser?->name ?? 'Robinson Naranjo',
            'userEmail' => $authUser?->email ?? 'superadmin@avipetapp.com',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'amount' => 'required|numeric|min:0',
            'gateway' => 'required|string',
            'plan_tier' => 'nullable|string',
            'status' => 'required|string',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $tenant = Tenant::findOrFail($validated['tenant_id']);

        $payment = SaasPaymentLog::create([
            'id' => Str::uuid(),
            'tenant_id' => $tenant->id,
            'order_id' => 'SAAS-MANUAL-' . strtoupper(Str::random(6)),
            'gateway' => $validated['gateway'],
            'amount' => $validated['amount'],
            'currency' => 'COP',
            'plan_tier' => $validated['plan_tier'] ?? 'pro',
            'status' => $validated['status'],
            'transaction_id' => 'MAN-' . strtoupper(Str::random(8)),
            'payer_name' => $tenant->branding['doctor_name'] ?? $tenant->name,
            'payer_email' => $tenant->branding['email'] ?? ($tenant->slug . '@avipetapp.com'),
            'period_start' => $validated['period_start'] ?? now(),
            'period_end' => $validated['period_end'] ?? now()->addDays(30),
            'notes' => $validated['notes'] ?? 'Cobro registrado manualmente desde SuperAdmin',
            'paid_at' => $validated['status'] === 'approved' ? now() : null,
        ]);

        // If approved, ensure tenant branding status is paid
        if ($validated['status'] === 'approved') {
            $branding = $tenant->branding ?? [];
            $branding['saas_status'] = 'paid';
            $branding['saas_next_payment_due'] = now()->addDays(30)->toDateString();
            $tenant->branding = $branding;
            $tenant->save();
        }

        return redirect()->back()->with('success', 'Pago registrado correctamente.');
    }
}
