<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\QuizAnswer;

class QuestionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'option_order',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class, 'selected_option_id');
    }
}
