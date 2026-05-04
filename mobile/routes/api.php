<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AuthController;

// Public Routes
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1'); // Limit 5 attempts per minute
Route::post('/login', [AuthController::class, 'apiLogin'])->middleware('throttle:10,1');
Route::get('/quizzes', [QuizController::class, 'getQuizzes']);

// Protected Routes
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/results', [QuizController::class, 'submitResult']);
    Route::get('/history', [QuizController::class, 'getUserHistory']);
});
