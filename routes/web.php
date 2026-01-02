<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\Auth\ParentAuthController;
use App\Http\Controllers\Teacher as TeacherNamespace;
use App\Http\Controllers\Parent as ParentNamespace;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Sitemap
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');


// Teacher Routes
Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::middleware('guest:teacher')->group(function () {
        Route::get('login', [TeacherAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [TeacherAuthController::class, 'login']);
        Route::get('register', [TeacherAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [TeacherAuthController::class, 'register']);
    });

    Route::middleware(['auth:teacher', \App\Http\Middleware\EnsureUserIsApproved::class])->group(function () {
        Route::get('dashboard', [TeacherNamespace\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('games', TeacherNamespace\GameController::class);
        
        // Question Routes
        Route::get('games/{game}/questions/create', [TeacherNamespace\GameQuestionController::class, 'create'])->name('games.questions.create');
        Route::post('games/{game}/questions', [TeacherNamespace\GameQuestionController::class, 'store'])->name('games.questions.store');
        Route::get('games/{game}/questions/{question}/edit', [TeacherNamespace\GameQuestionController::class, 'edit'])->name('games.questions.edit');
        Route::put('games/{game}/questions/{question}', [TeacherNamespace\GameQuestionController::class, 'update'])->name('games.questions.update');
        Route::delete('games/{game}/questions/{question}', [TeacherNamespace\GameQuestionController::class, 'destroy'])->name('games.questions.destroy');
        
        Route::post('logout', [TeacherAuthController::class, 'logout'])->name('logout');
    });
});

// Parent Routes
Route::prefix('parent')->name('parent.')->group(function () {
    Route::middleware('guest:parent')->group(function () {
        Route::get('login', [ParentAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [ParentAuthController::class, 'login']);
        Route::get('register', [ParentAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [ParentAuthController::class, 'register']);
    });

    Route::middleware(['auth:parent', \App\Http\Middleware\EnsureUserIsApproved::class])->group(function () {
        Route::get('dashboard', [ParentNamespace\DashboardController::class, 'index'])->name('dashboard');
        Route::get('select-child/{student}', [ParentNamespace\DashboardController::class, 'selectChild'])->name('select-child');
        
        // New parent features
        Route::get('schedules', [ParentNamespace\DashboardController::class, 'viewSchedules'])->name('schedules');
        Route::get('progress', [ParentNamespace\DashboardController::class, 'viewProgress'])->name('progress');
        Route::get('game-results', [ParentNamespace\DashboardController::class, 'viewGameResults'])->name('game-results');
        
        // Reports
        Route::get('reports/weekly/{student}', [ParentNamespace\ReportController::class, 'weeklyReport'])->name('reports.weekly');
        Route::get('reports/game/{session}', [ParentNamespace\ReportController::class, 'gameReport'])->name('reports.game');
        
        // Student Game Routes (Accessible via Parent View)
        Route::prefix('games')->name('games.')->group(function () {
             Route::get('/', [\App\Http\Controllers\Student\GameSessionController::class, 'index'])->name('index');
             Route::get('/{game}', [\App\Http\Controllers\Student\GameSessionController::class, 'show'])->name('show');
             Route::post('/{game}/start', [\App\Http\Controllers\Student\GameSessionController::class, 'start'])->name('start');
             Route::get('/session/{session}/play', [\App\Http\Controllers\Student\GameSessionController::class, 'play'])->name('play');
             Route::post('/session/{session}/answer', [\App\Http\Controllers\Student\GameSessionController::class, 'answer'])->name('answer');
             Route::get('/session/{session}/result', [\App\Http\Controllers\Student\GameSessionController::class, 'result'])->name('result');
        });

        Route::post('logout', [ParentAuthController::class, 'logout'])->name('logout');
    });
});
