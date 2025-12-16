<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vocab_words', function (Blueprint $table) {
            $table->id();

            $table->foreignId('deck_id')
                ->constrained('decks')
                ->cascadeOnDelete();

            $table->string('term', 255);                 // từ gốc (汉字 / English)
            $table->string('reading', 255)->nullable();  // pinyin / romaji...
            $table->string('meaning_vi', 255);
            $table->string('meaning_en', 255)->nullable();
            $table->text('example_sentence')->nullable();
            $table->text('example_translation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocab_words');
    }
};
