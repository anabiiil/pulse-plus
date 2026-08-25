<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * A medical record (medical_files) can hold a group of attachments
     * (multiple scans/analyses images or PDFs).
     */
    public function up(): void
    {
        Schema::create('medical_file_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_file_id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_file_attachments');
    }
};
