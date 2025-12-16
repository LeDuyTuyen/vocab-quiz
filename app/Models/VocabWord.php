<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deck;
use App\Models\Question;
use App\Models\QuizAnswer;

class VocabWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'deck_id',
        'term',
        'reading',
        'meaning_vi',
        'meaning_en',
        'example_sentence',
        'example_translation',
    ];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
