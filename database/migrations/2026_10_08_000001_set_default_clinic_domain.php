<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tenants')
            ->where('slug', 'vet-pet-patitas')
            ->where(function ($query) {
                $query->whereNull('domain')
                      ->orWhere('domain', '')
                      ->orWhere('domain', 'patitas.aviplan.co');
            })
            ->update([
                'domain' => 'vet-pet-patitas.avipetapp.com',
            ]);
    }

    public function down(): void
    {
        // No-op
    }
};
