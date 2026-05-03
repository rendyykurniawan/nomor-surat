<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->boolean('is_mundur')->default(false)->after('urutan');
            $table->string('suffix')->nullable()->after('is_mundur'); // 'A', 'B', 'C'
            $table->string('nomor_referensi')->nullable()->after('suffix'); // menyimpan nomor asli yg dirujuk, misal '008'
        });
    }

    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn(['is_mundur', 'suffix', 'nomor_referensi']);
        });
    }
};
