<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('source_id')->nullable()->constrained('lead_sources')->nullOnDelete();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->json('skills')->nullable();
            $table->string('platform')->nullable();
            $table->string('url')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->string('client_country')->nullable();
            $table->string('language', 10)->nullable();
            $table->json('tags')->nullable();
            $table->longText('raw_text')->nullable();
            $table->string('dedupe_hash')->index();
            $table->string('status')->default('new');
            $table->timestamps();

            $table->unique(['user_id', 'url']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
