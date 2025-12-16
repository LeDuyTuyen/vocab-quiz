<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'vocab_word_id',
        'type',
        'prompt',
        'explanation',
    ];

    public function vocabWord()
    {
        return $this->belongsTo(VocabWord::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
