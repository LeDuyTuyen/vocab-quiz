<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vocab_word_id')
                ->constrained('vocab_words')
                ->cascadeOnDelete();

            // vd: multiple_choice, written,...
            $table->string('type', 50)->default('multiple_choice');

            // đề bài hiển thị cho user
            $table->text('prompt');

            // giải thích khi xem lại đáp án
            $table->text('explanation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
