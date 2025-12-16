<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'level',
        'language',
        'description',
        'is_public',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function words()
    {
        return $this->hasMany(VocabWord::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(Question::class, VocabWord::class);
    }

    public function quizSessions()
    {
        return $this->hasMany(QuizSession::class);
    }
}
