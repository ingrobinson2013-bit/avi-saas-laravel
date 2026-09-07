<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pets', 'photo_url')) {
            Schema::table('pets', function (Blueprint $table) {
                $table->string('photo_url', 1000)->nullable()->after('breed');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pets', 'photo_url')) {
            Schema::table('pets', function (Blueprint $table) {
                $table->dropColumn('photo_url');
            });
        }
    }
};
