<?php

use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Sanitizar todos los tenants que no sean la clínica piloto 'vet-pet-patitas'
        $tenants = Tenant::where('slug', '!=', 'vet-pet-patitas')->get();

        foreach ($tenants as $tenant) {
            $branding = $tenant->branding ?? [];

            // Limpiar logo si apunta al R2 de Patitas
            if (!empty($branding['logo_url']) && str_contains($branding['logo_url'], '01M1WM7VP4PYQVQ7P0GBWK1RPW')) {
                $branding['logo_url'] = null;
            }

            // Limpiar video si apunta al video de Patitas
            if (!empty($branding['banner_video_url']) && str_contains($branding['banner_video_url'], '01M1WMMTC4TCADMGJPNSESE0GR')) {
                $branding['banner_video_url'] = null;
            }

            // Limpiar hero si apunta a la foto de equipo Patitas
            if (!empty($branding['hero_image_url']) && str_contains($branding['hero_image_url'], '01M1FEY7TJ5HDAE20YXX3X46G4')) {
                $branding['hero_image_url'] = 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=700&auto=format&fit=crop&q=80';
            }

            // Limpiar banner si apunta a Patitas
            if (!empty($branding['banner_image_url']) && str_contains($branding['banner_image_url'], '01M1WMMT19GBVFKCHN2BWNNMF4')) {
                $branding['banner_image_url'] = 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=1000';
            }

            // Limpiar cuenta bancaria de Patitas
            if (!empty($branding['payment_bank_info']) && str_contains($branding['payment_bank_info'], 'Vet-Pet Patitas')) {
                $branding['payment_bank_info'] = '';
            }

            // Limpiar link de Bold de Patitas
            if (!empty($branding['payment_bold_link']) && str_contains($branding['payment_bold_link'], 'LNK_VET_PATITAS')) {
                $branding['payment_bold_link'] = '';
            }

            // Limpiar dirección si tiene la de Cajicá de Patitas
            if (!empty($branding['address']) && str_contains($branding['address'], 'Calle 7 # 4-73 Este')) {
                $branding['address'] = 'Sede Principal';
            }

            $tenant->branding = $branding;
            $tenant->save();
        }
    }

    public function down(): void
    {
        // No-op
    }
};
