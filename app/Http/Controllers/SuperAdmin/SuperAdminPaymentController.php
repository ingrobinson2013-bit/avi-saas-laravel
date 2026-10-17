<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SaasPaymentLog;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SuperAdminPaymentController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');
        $gateway = $request->input('gateway', 'all');

        $query = SaasPaymentLog::with(['tenant.users'])->latest();

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
            if ($gateway === 'bold') {
                $query->whereIn('gateway', ['bold', 'bold_wompi']);
            } else {
                $query->where('gateway', $gateway);
            }
        }

        $payments = $query->paginate(25)->through(function (SaasPaymentLog $p) {
            $tenant = $p->tenant;
            $branding = $tenant?->branding ?? [];
            $primaryUser = $tenant?->users?->first();

            $resolvedEmail = $p->payer_email
                ?: ($branding['email'] ?? ($primaryUser?->email ?? null));
            $resolvedName = $p->payer_name
                ?: ($branding['doctor_name'] ?? ($primaryUser?->name ?? ($tenant?->name ?? 'Dirección Médica')));
            $resolvedPhone = $p->payer_phone
                ?: ($branding['phone'] ?? null);

            return [
                'id' => $p->id,
                'order_id' => $p->order_id ?? ('ORD-' . strtoupper(substr($p->id, 0, 8))),
                'tenant_id' => $p->tenant_id,
                'tenant_name' => $tenant?->name ?? 'Clínica no asignada',
                'tenant_slug' => $tenant?->slug ?? '',
                'amount' => (float) $p->amount,
                'currency' => $p->currency ?? 'COP',
                'gateway' => $p->gateway ?? 'bold',
                'plan_tier' => $p->plan_tier ?? 'starter',
                'status' => $p->status ?? 'approved',
                'transaction_id' => $p->transaction_id,
                'payer_name' => $resolvedName,
                'payer_email' => $resolvedEmail,
                'payer_phone' => $resolvedPhone,
                'period_start' => $p->period_start ? $p->period_start->format('d/m/Y') : null,
                'period_end' => $p->period_end ? $p->period_end->format('d/m/Y') : null,
                'period_start_iso' => $p->period_start ? $p->period_start->format('Y-m-d') : null,
                'period_end_iso' => $p->period_end ? $p->period_end->format('Y-m-d') : null,
                'notes' => $p->notes,
                'paid_at' => $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : null,
                'created_at' => $p->created_at ? $p->created_at->format('d/m/Y H:i') : null,
            ];
        });

        // KPIs reales desde la base de datos
        $totalRecaudado = (float) SaasPaymentLog::where('status', 'approved')->sum('amount');
        $aprobadosCount = SaasPaymentLog::where('status', 'approved')->count();
        $pendientesCount = SaasPaymentLog::where('status', 'pending')->count();
        $pendientesMonto = (float) SaasPaymentLog::where('status', 'pending')->sum('amount');
        $fallidosCount = SaasPaymentLog::where('status', 'failed')->count();

        // MRR de la plataforma: solo clínicas activas con suscripción activa (excluyendo clínicas de prueba 'test')
        $activePaidTenants = Tenant::where('is_active', true)->get()->filter(function (Tenant $t) {
            if (in_array(strtolower($t->slug), ['test', 'demo'])) {
                return false;
            }
            $st = $t->branding['saas_status'] ?? 'paid';
            return $st === 'paid';
        });

        $mrr = (float) $activePaidTenants->sum(function (Tenant $t) {
            return (float) ($t->branding['saas_monthly_fee'] ?? 99000);
        });

        $allTenants = Tenant::select('id', 'name', 'slug', 'branding')->orderBy('name')->get()->map(fn ($t) => [
            'id' => $t->id,
            'name' => $t->name,
            'slug' => $t->slug,
            'default_fee' => (float) ($t->branding['saas_monthly_fee'] ?? 99000),
            'default_plan' => $t->branding['saas_plan'] ?? 'starter',
        ]);

        $authUser = (auth()->user() && auth()->user()->role === 'super_admin')
            ? auth()->user()
            : User::where('role', 'super_admin')->orWhere('email', 'contacto@avipetapp.com')->first();

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
                'fallidosCount' => $fallidosCount,
                'mrr' => $mrr,
                'activePaidClinics' => $activePaidTenants->count(),
            ],
            'tenantsList' => $allTenants,
            'userName' => $authUser?->name ?? 'Robinson Naranjo',
            'userEmail' => $authUser?->email ?? 'contacto@avipetapp.com',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'amount' => 'required|numeric|min:0',
            'gateway' => 'required|string|max:50',
            'plan_tier' => 'nullable|string|max:50',
            'status' => 'required|in:approved,pending,failed',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $tenant = Tenant::with('users')->findOrFail($validated['tenant_id']);
        $primaryUser = $tenant->users->first();

        SaasPaymentLog::create([
            'id' => Str::uuid(),
            'tenant_id' => $tenant->id,
            'order_id' => 'SAAS-' . strtoupper(Str::random(6)),
            'gateway' => $validated['gateway'],
            'amount' => $validated['amount'],
            'currency' => 'COP',
            'plan_tier' => $validated['plan_tier'] ?? 'starter',
            'status' => $validated['status'],
            'transaction_id' => 'TRX-' . strtoupper(Str::random(8)),
            'payer_name' => $tenant->branding['doctor_name'] ?? ($primaryUser?->name ?? $tenant->name),
            'payer_email' => $tenant->branding['email'] ?? ($primaryUser?->email ?? null),
            'payer_phone' => $tenant->branding['phone'] ?? null,
            'period_start' => $validated['period_start'] ?? now(),
            'period_end' => $validated['period_end'] ?? now()->addDays(30),
            'notes' => $validated['notes'] ?? 'Cobro registrado desde SuperAdmin',
            'paid_at' => $validated['status'] === 'approved' ? now() : null,
        ]);

        if ($validated['status'] === 'approved') {
            $branding = $tenant->branding ?? [];
            $branding['saas_status'] = 'paid';
            $branding['saas_plan'] = $validated['plan_tier'] ?? ($branding['saas_plan'] ?? 'starter');
            $branding['saas_monthly_fee'] = (float) $validated['amount'];
            $branding['saas_next_payment_due'] = !empty($validated['period_end'])
                ? \Carbon\Carbon::parse($validated['period_end'])->toDateString()
                : now()->addDays(30)->toDateString();

            $tenant->update([
                'is_active' => true,
                'saas_plan_tier' => $branding['saas_plan'],
                'branding' => $branding,
            ]);
        }

        return redirect()->back()->with('success', 'Pago registrado y suscripción actualizada correctamente.');
    }

    public function update(Request $request, string $id)
    {
        $payment = SaasPaymentLog::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'gateway' => 'required|string|max:50',
            'plan_tier' => 'required|string|max:50',
            'status' => 'required|in:approved,pending,failed',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date',
            'payer_email' => 'nullable|email|max:150',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment->update([
            'amount' => $validated['amount'],
            'gateway' => $validated['gateway'],
            'plan_tier' => $validated['plan_tier'],
            'status' => $validated['status'],
            'period_start' => $validated['period_start'] ?: $payment->period_start,
            'period_end' => $validated['period_end'] ?: $payment->period_end,
            'payer_email' => $validated['payer_email'] ?: $payment->payer_email,
            'notes' => $validated['notes'],
            'paid_at' => $validated['status'] === 'approved' ? ($payment->paid_at ?? now()) : null,
        ]);

        if ($payment->tenant_id && $validated['status'] === 'approved') {
            $tenant = Tenant::find($payment->tenant_id);
            if ($tenant) {
                $branding = $tenant->branding ?? [];
                $branding['saas_status'] = 'paid';
                $branding['saas_plan'] = $validated['plan_tier'];
                $branding['saas_monthly_fee'] = (float) $validated['amount'];
                if (!empty($validated['period_end'])) {
                    $branding['saas_next_payment_due'] = \Carbon\Carbon::parse($validated['period_end'])->toDateString();
                }
                $tenant->update([
                    'is_active' => true,
                    'saas_plan_tier' => $validated['plan_tier'],
                    'branding' => $branding,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Orden de pago actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $payment = SaasPaymentLog::findOrFail($id);
        $payment->delete();

        return redirect()->back()->with('success', 'Registro de pago eliminado.');
    }
}
