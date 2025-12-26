<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DeckManageController extends Controller
{
    public function index(Request $request)
    {
        $decks = Deck::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Quiz/MyDecks/Index', [
            'auth' => [
                'user' => $request->user(),
            ],
            'decks' => $decks,
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Quiz/MyDecks/Edit', [
            'auth' => [
                'user' => $request->user(),
            ],
            'deck' => null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'language'    => ['nullable', 'string', 'max:10'],
            'level'       => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_public'   => ['sometimes', 'boolean'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['is_public'] = $data['is_public'] ?? false;
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(6);

        Deck::create($data);

        return redirect()
            ->route('quiz.my-decks.index')
            ->with('success', 'Tạo deck mới thành công.');
    }

    public function edit(Request $request, Deck $deck)
    {
        if ($deck->user_id !== $request->user()->id) {
            abort(403);
        }

        return Inertia::render('Quiz/MyDecks/Edit', [
            'auth' => [
                'user' => $request->user(),
            ],
            'deck' => $deck,
        ]);
    }

    public function update(Request $request, Deck $deck)
    {
        if ($deck->user_id !== $request->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'language'    => ['nullable', 'string', 'max:10'],
            'level'       => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_public'   => ['sometimes', 'boolean'],
        ]);

        $data['is_public'] = $data['is_public'] ?? false;

        $deck->update($data);

        return redirect()
            ->route('quiz.my-decks.index')
            ->with('success', 'Cập nhật deck thành công.');
    }

    public function destroy(Request $request, Deck $deck)
    {
        if ($deck->user_id !== $request->user()->id) {
            abort(403);
        }

        $deck->delete();

        return redirect()
            ->route('quiz.my-decks.index')
            ->with('success', 'Đã xoá deck.');
    }
}
