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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // FK ke tabel users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // FK ke tabel activity_types
            $table->foreignId('activity_type_id')
                  ->constrained('activity_types')
                  ->onDelete('restrict');
            
            // FK ke tabel letter_types
            $table->foreignId('letter_type_id')
                  ->constrained('letter_types')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('letter_id')->nullable();

            $table->foreignId('regency_id')
                  ->nullable()
                  ->constrained('regencies')
                  ->onDelete('cascade');
            
            // Menyediakan kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
