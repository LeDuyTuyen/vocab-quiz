<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->id();

            // null nếu là deck hệ thống (không thuộc user cụ thể)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->string('level', 50)->nullable();   // HSK1, HSK2, TOEIC, ...
            $table->string('language', 20);            // 'zh', 'en', 'ko',...
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decks');
    }
};
