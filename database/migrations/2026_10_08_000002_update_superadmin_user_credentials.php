<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Actualizar cuenta anterior superadmin@aviplan.co si existe
        $oldSuper = User::where('email', 'superadmin@aviplan.co')->first();
        if ($oldSuper) {
            $oldSuper->update([
                'email' => 'contacto@avipetapp.com',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'super_admin',
                'name' => 'Dr. Robinson Naranjo (CEO NODIA)',
            ]);
            return;
        }

        // 2. Crear o actualizar contacto@avipetapp.com como SuperAdmin
        User::updateOrCreate(
            ['email' => 'contacto@avipetapp.com'],
            [
                'name' => 'Dr. Robinson Naranjo (CEO NODIA)',
                'password' => Hash::make('Ashley2023##'),
                'role' => 'super_admin',
            ]
        );
    }

    public function down(): void
    {
        // No-op
    }
};
