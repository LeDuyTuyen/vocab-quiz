<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Quiz\DeckController;
use App\Http\Controllers\Quiz\DeckManageController;
use App\Http\Controllers\Quiz\QuizController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->prefix('quiz')->group(function () {
    Route::get('/decks', [DeckController::class, 'index'])->name('quiz.decks.index');
    Route::get('/decks/{deck}', [DeckController::class, 'show'])->name('quiz.decks.show');

    Route::get('/decks/{deck}/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::post('/sessions/{session}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/sessions/{session}', [QuizController::class, 'result'])->name('quiz.result');

     // Quiz Builder - quản lý deck của user
     Route::get('/my-decks', [DeckManageController::class, 'index'])->name('quiz.my-decks.index');
     Route::get('/my-decks/create', [DeckManageController::class, 'create'])->name('quiz.my-decks.create');
     Route::post('/my-decks', [DeckManageController::class, 'store'])->name('quiz.my-decks.store');
     Route::get('/my-decks/{deck}/edit', [DeckManageController::class, 'edit'])->name('quiz.my-decks.edit');
     Route::put('/my-decks/{deck}', [DeckManageController::class, 'update'])->name('quiz.my-decks.update');
     Route::delete('/my-decks/{deck}', [DeckManageController::class, 'destroy'])->name('quiz.my-decks.destroy');
});

require __DIR__.'/auth.php';
