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

    // Users Management (Admins & Participants)
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
    Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
    Route::post('/users/{id}/toggle-status', [\App\Http\Controllers\UserController::class, 'toggleDisqualification']);

    // Results
    Route::delete('/results/{id}', [QuizController::class, 'deleteResult']);
});

// Storage Proxy (InfinityFree Workaround for disabled symlinks)
Route::get('/storage/{path}', function ($path) {
    $path = storage_path('app/public/' . $path);

    if (!file_exists($path)) {
        abort(404);
    }

    $file = file_get_contents($path);
    $type = mime_content_type($path);

    return response($file, 200)->header("Content-Type", $type);
})->where('path', '.*');
