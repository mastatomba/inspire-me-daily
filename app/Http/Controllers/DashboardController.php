<?php

namespace App\Http\Controllers;

use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    private const FETCH_QUOTES_LOCK = 'FETCH_QUOTES_LOCK';

    /**
     * Show the dashboard page
     */
    public function show(Request $request): Response
    {
        $quoteService = new QuoteService();

        if (!Cache::has(self::FETCH_QUOTES_LOCK)) {
            $quoteService->fetchQuotes();
            Cache::put(self::FETCH_QUOTES_LOCK, true, 30);
        }

        return Inertia::render('Dashboard', [
            'quote' => $quoteService->getRandomQuote(),
            'card_color' => random_int(1, 3)
        ]);
    }
}