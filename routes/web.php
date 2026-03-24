<?php

use App\Http\Controllers\Web\AdminAuthController;
use App\Http\Controllers\Web\AdminSessionController;
use App\Http\Controllers\Web\CandidateTestController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('admin.dashboard'));

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin.auth'])->prefix('admin')->group(function (): void {
    Route::get('/', [AdminSessionController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/sessions/new', [AdminSessionController::class, 'create'])->name('admin.sessions.create');
    Route::post('/sessions/new', [AdminSessionController::class, 'store'])->name('admin.sessions.store');
    Route::get('/sessions/{session}', [AdminSessionController::class, 'show'])->name('admin.sessions.show');
    Route::get('/candidates/{attempt}', [AdminSessionController::class, 'candidate'])->name('admin.candidates.show');
});

Route::get('/test/{token}', [CandidateTestController::class, 'testLanding'])->name('candidate.test');
Route::post('/test/{token}/register', [CandidateTestController::class, 'register'])->name('candidate.register');
Route::get('/solve/{token}', [CandidateTestController::class, 'solve'])->name('candidate.solve');
Route::post('/solve/{token}/run', [CandidateTestController::class, 'run'])->name('candidate.run');
Route::post('/solve/{token}/submit', [CandidateTestController::class, 'submit'])->name('candidate.submit');
Route::get('/result/{token}', [CandidateTestController::class, 'result'])->name('candidate.result');
