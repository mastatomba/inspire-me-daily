<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller
{
    /**
     * Show the top 25 quotes page
     */
    public function listTop25(Request $request): Response
    {
        $quoteService = new QuoteService();
        $quotes = $quoteService->getTopRatedQuotes(25)->map(function(Quote $quote) {
            return [
                "id" => $quote->id,
                "author" => $quote->author,
                "quote" => $quote->quote,
                "rating" => number_format($quote->calculateRating(), 2, '.', ''),
                "votes" => $quote->getNumberOfVotes(),
            ];
        });

        Log::debug("top 25 quotes", ["quotes"=>$quotes]);

        return Inertia::render('Top25', [
            'quotes' => $quotes
        ]);
    }
}