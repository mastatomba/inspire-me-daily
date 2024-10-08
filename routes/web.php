<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuoteRatingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'randomQuote'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/show_quote', [QuoteController::class, 'show'])->middleware(['auth', 'verified'])->name('quote.show');
Route::get('/top25', [QuoteController::class, 'listTop25'])->middleware(['auth', 'verified'])->name('quote.top25_ratings');
Route::get('/my_ratings', [QuoteController::class, 'listCurrentUserRatings'])->middleware(['auth', 'verified'])->name('quote.user_ratings');
Route::get('/get_rating_breakdown', [QuoteController::class, 'getRatingBreakdown'])->middleware(['auth', 'verified'])->name('quote.rating_breakdown');

Route::post('/save_rating', [QuoteRatingController::class, 'updateOrCreate'])->middleware(['auth', 'verified'])->name('rating.save');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
