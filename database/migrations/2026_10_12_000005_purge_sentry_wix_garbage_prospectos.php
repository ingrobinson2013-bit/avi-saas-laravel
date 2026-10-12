<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Elimina correos técnicos, DSNs de Sentry y scripts Wix extraídos por error.
     */
    public function up(): void
    {
        DB::table('prospectos_veterinarias')
            ->where('correo_comercial', 'LIKE', '%sentry%')
            ->orWhere('correo_comercial', 'LIKE', '%wixpress%')
            ->orWhere('correo_comercial', 'LIKE', '%cloudflare%')
            ->orWhere('correo_comercial', 'LIKE', '%wordpress%')
            ->orWhere('correo_comercial', 'LIKE', '%schema.org%')
            ->orWhere('correo_comercial', 'LIKE', '%example.com%')
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No revertir purga de datos basura
    }
};
