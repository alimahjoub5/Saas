<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_analyses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->json('summary')->nullable();
            $table->json('skills')->nullable();
            $table->string('language', 10)->nullable();
            $table->json('red_flags')->nullable();
            $table->json('scoring')->nullable();
            $table->foreignId('prompt_log_id')->nullable()->constrained('prompt_logs')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_analyses');
    }
};
