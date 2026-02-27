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
        // Menambah kolom di tabel letters
        Schema::table('letters', function (Blueprint $table) {
            $table->date('start_date')->nullable(); // Boleh kosong (untuk surat tipe 11, 12, 21)
            $table->date('end_date')->nullable();
        });

        // Menambah kolom di tabel opds (Sesuai request Anda)
        Schema::table('opds', function (Blueprint $table) {
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
        });
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
};
