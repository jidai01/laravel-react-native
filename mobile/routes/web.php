<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;

Route::get('/', function () {
    return redirect('/login');
});

// Admin Auth
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Admin Dashboard & Management
Route::get('/dashboard', [QuizController::class, 'dashboard']);

Route::prefix('admin')->group(function () {
    // Quizzes
    Route::get('/quizzes', [QuizController::class, 'indexQuizzes']);
    Route::post('/quizzes', [QuizController::class, 'storeQuiz']);
    Route::put('/quizzes/{id}', [QuizController::class, 'updateQuiz']);
    Route::delete('/quizzes/{id}', [QuizController::class, 'deleteQuiz']);

    // Participants
    Route::get('/participants', [QuizController::class, 'indexParticipants']);
    Route::post('/participants/{id}/reset', [QuizController::class, 'resetDisqualification']);
    Route::delete('/participants/{id}', [QuizController::class, 'deleteParticipant']);

    // Results
    Route::delete('/results/{id}', [QuizController::class, 'deleteResult']);
});
