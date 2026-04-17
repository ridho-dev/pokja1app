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
        Schema::create('letter_opd', function (Blueprint $table) {
            $table->foreignId('letter_id')
                    ->constrained('letters')
                    ->cascadeOnDelete();
            $table->string('opd_id', 8)
                    ->foreignId('opd_id')
                    ->constrained('opds')
                    ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_opd');
    }
};
