<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ClinicFlyerController extends Controller
{
    /**
     * Muestra el afiche publicitario interactivo de alta resolución listo para imprimir.
     */
    public function show(string $slug)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();
        $plans = $tenant->plans()->where('is_active', true)->with('planBenefits.benefitDefinition')->get();

        $primaryColor = $tenant->branding['primary_color'] ?? '#0D9488';
        $secondaryColor = $tenant->branding['secondary_color'] ?? '#0B1120';
        $logoUrl = $tenant->branding['logo_url'] ?? null;
        $city = $tenant->branding['city'] ?? 'Cajicá, Cundinamarca';
        $address = $tenant->branding['address'] ?? 'Calle 7 # 4-73 Este';
        $phone = $tenant->branding['phone'] ?? '3508742543';

        // URL a la que apunta el QR
        $enrollmentUrl = url("/v/{$tenant->slug}");
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=" . urlencode($enrollmentUrl);

        return view('clinic_flyer', compact(
            'tenant',
            'plans',
            'primaryColor',
            'secondaryColor',
            'logoUrl',
            'city',
            'address',
            'phone',
            'enrollmentUrl',
            'qrCodeUrl'
        ));
    }

    /**
     * Descarga directa en PDF tamaño carta/A4 del afiche.
     */
    public function downloadPdf(string $slug)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();
        
        if (class_exists(Pdf::class)) {
            $plans = $tenant->plans()->where('is_active', true)->with('planBenefits.benefitDefinition')->get();
            $primaryColor = $tenant->branding['primary_color'] ?? '#0D9488';
            $secondaryColor = $tenant->branding['secondary_color'] ?? '#0B1120';
            $logoUrl = $tenant->branding['logo_url'] ?? null;
            $city = $tenant->branding['city'] ?? 'Cajicá, Cundinamarca';
            $address = $tenant->branding['address'] ?? 'Calle 7 # 4-73 Este';
            $phone = $tenant->branding['phone'] ?? '3508742543';
            $enrollmentUrl = url("/v/{$tenant->slug}");
            $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=" . urlencode($enrollmentUrl);

            $pdf = Pdf::loadView('clinic_flyer', compact(
                'tenant',
                'plans',
                'primaryColor',
                'secondaryColor',
                'logoUrl',
                'city',
                'address',
                'phone',
                'enrollmentUrl',
                'qrCodeUrl'
            ))->setPaper('letter', 'portrait');

            return $pdf->download("Afiche-Mostrador-{$tenant->slug}.pdf");
        }

        return redirect()->route('clinic.flyer', ['slug' => $slug]);
    }
}
