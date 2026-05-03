<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            $table->unsignedBigInteger('kode_kategori_id')->nullable()->after('id');

            $table->foreign('kode_kategori_id')
                ->references('id')
                ->on('kode_kategori')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            $table->dropForeign(['kode_kategori_id']);
            $table->dropColumn('kode_kategori_id');
        });
    }
};
