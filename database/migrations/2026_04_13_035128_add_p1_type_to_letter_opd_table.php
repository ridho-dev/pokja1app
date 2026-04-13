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
        Schema::table('letter_opd', function (Blueprint $table) {
            $table->foreignId('p1_type_id')
              ->nullable()
              ->after('opd_id')
              ->constrained('p1_types')
              ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letter_opd', function (Blueprint $table) {
            //
        });
    }
};
