<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deck_id',
        'total_questions',
        'correct_answers',
        'started_at',
        'finished_at',
    ];

    protected $dates = [
        'started_at',
        'finished_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
