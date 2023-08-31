<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_files', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->morphs('model');

            $table->foreignId('document_template_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('document_type')->nullable()->index();
            $table->string('path');
            $table->unsignedBigInteger('size')->nullable();
            $table->json('variables')->nullable();
            $table->json('options')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_files');
    }
};
