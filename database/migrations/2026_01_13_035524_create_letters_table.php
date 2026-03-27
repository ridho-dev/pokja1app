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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            
            $table->string('file_name');
            $table->string('kloter')->nullable();
            $table->string('letter_number')->nullable();
            $table->date('letter_date')->nullable();
            
            $table->foreignId('letter_type_id')
                    ->constrained('letter_types')
                    ->cascadeOnDelete();
            
            $table->timestamp('uploaded_date')->useCurrent()->nullable(); 
            $table->foreignId('uploaded_by')
                    ->nullable()
                    ->constrained('users')
                    ->cascadeOnDelete();
            
            $table->timestamp('updated_date')->nullable();
            $table->foreignId('updated_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete(); 
            
            $table->text('information')->nullable();
            $table->string('file_path');
            
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
