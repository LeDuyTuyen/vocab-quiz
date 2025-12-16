<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use App\Models\QuizSession;
use App\Models\QuizAnswer;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function start(Deck $deck, Request $request)
    {
        if (!$deck->is_public && $deck->user_id !== auth()->id()) {
            abort(403);
        }

        $numQuestions = (int) ($request->get('num') ?? 10);

        $questions = $deck->questions()
            ->with('options')
            ->inRandomOrder()
            ->take($numQuestions)
            ->get();

        if ($questions->isEmpty()) {
            return redirect()
                ->route('quiz.decks.show', $deck)
                ->with('error', 'Deck này chưa có câu hỏi nào.');
        }

        $session = QuizSession::create([
            'user_id'         => auth()->id(),
            'deck_id'         => $deck->id,
            'total_questions' => $questions->count(),
            'correct_answers' => 0,
            'started_at'      => now(),
        ]);

        return Inertia::render('Quiz/Play', [
            'deck'      => $deck,
            'session'   => $session,
            'questions' => $questions,
        ]);
    }

    public function submit(QuizSession $session, Request $request)
    {
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'answers'   => 'required|array',
            'answers.*' => 'nullable|integer',
        ]);

        $answersInput = $data['answers'] ?? [];
        $correctCount = 0;

        foreach ($answersInput as $questionId => $optionId) {
            $questionOption = $optionId
                ? QuestionOption::find($optionId)
                : null;

            $isCorrect = $questionOption && $questionOption->is_correct;

            if ($isCorrect) {
                $correctCount++;
            }

            QuizAnswer::create([
                'quiz_session_id'    => $session->id,
                'question_id'        => $questionId,
                'selected_option_id' => $optionId ?: null,
                'user_answer'        => null,
                'is_correct'         => $isCorrect,
                'answered_at'        => now(),
            ]);
        }

        $session->update([
            'correct_answers' => $correctCount,
            'finished_at'     => now(),
        ]);

        return redirect()->route('quiz.result', $session);
    }

    public function result(QuizSession $session)
    {
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        $session->load([
            'deck',
            'answers.question.options',
        ]);

        return Inertia::render('Quiz/Result', [
            'session' => $session,
        ]);
    }
}
