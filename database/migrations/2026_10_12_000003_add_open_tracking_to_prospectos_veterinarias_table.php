<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prospectos_veterinarias', function (Blueprint $table) {
            $table->timestamp('abierto_at')->nullable()->index()->after('ultimo_envio_at');
            $table->unsignedInteger('aperturas_count')->default(0)->after('abierto_at');
        });
    }

    public function down(): void
    {
        Schema::table('prospectos_veterinarias', function (Blueprint $table) {
            $table->dropColumn(['abierto_at', 'aperturas_count']);
        });
    }
};
