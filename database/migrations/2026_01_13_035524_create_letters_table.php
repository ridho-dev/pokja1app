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

            $table->string('province_id')->constrained('provinces')->onDelete('cascade');
            $table->foreignId('regency_id')->constrained('regencies')->onDelete('cascade');
            $table->foreignId('opd_id')->constrained('opds')->onDelete('cascade');

            $table->foreignId('letter_type_id')->constrained('letter_types');

            $table->date('letter_date');
            $table->timestamp('upload_date')->useCurrent();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamp('updated_date')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->text('information')->nullable();
            $table->string('file_path');
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
