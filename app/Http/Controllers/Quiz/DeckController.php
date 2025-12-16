<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeckController extends Controller
{
    public function index()
    {
        $decks = Deck::query()
            ->where('is_public', true)
            ->orWhere('user_id', auth()->id())
            ->withCount('words')
            ->orderBy('name')
            ->get();

        return Inertia::render('Quiz/Index', [
            'decks' => $decks,
        ]);
    }

    public function show(Deck $deck)
    {
        if (!$deck->is_public && $deck->user_id !== auth()->id()) {
            abort(403);
        }

        $deck->loadCount('words')->load('questions');

        return Inertia::render('Quiz/Show', [
            'deck' => $deck,
        ]);
    }
}
