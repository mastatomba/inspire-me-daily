<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteRating;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class QuoteController extends Controller
{
    /**
     * Show the quote
     */
    public function show(Request $request): Response
    {
        $quote = Quote::find($request->id);

        return Inertia::render('Dashboard', [
            'quote' => $quote->only([
                'id',
                'author',
                'quote'
            ]),
            'rating' => $quote->getUserRating(Auth::user()->id)
        ]);
    }

    public function getRatingBreakdown(Request $request): array
    {
        $quote = Quote::find($request->id);
        $ratings = $quote->ratings;

        $votesPerRatings = [
            'rating_1' => 0,
            'rating_2' => 0,
            'rating_3' => 0,
            'rating_4' => 0,
            'rating_5' => 0
        ];
        foreach ($ratings as $rating)
        {
            $votesPerRatings['rating_' . $rating->rating] += 1;
        }

        return $votesPerRatings + [
            'total' => $ratings->count()
        ];
    }

    /**
     * Show the top 25 quotes page
     */
    public function listTop25(Request $request): Response
    {
        $quoteService = new QuoteService();
        $quotes = $quoteService->getTopRatedQuotes(25)->map(function(Quote $quote) {
            return [
                'id' => $quote->id,
                'author' => $quote->author,
                'quote' => $quote->quote,
                'rating' => number_format($quote->calculateRating(), 2, '.', ''),
                'votes' => $quote->getNumberOfVotes(),
            ];
        });

        return Inertia::render('Top25', [
            'quotes' => $quotes
        ]);
    }

    /**
     * Show the my ratings page
     */
    public function listCurrentUserRatings(Request $request): Response
    {
        $quoteService = new QuoteService();
        $quotes = $quoteService->getQuotesRatedByUser(Auth::user()->id)->map(function(QuoteRating $quoteRating) {
            $quote = $quoteRating->quote;
            return [
                'id' => $quote->id,
                'author' => $quote->author,
                'quote' => $quote->quote,
                'rating' => number_format($quote->calculateRating(), 2, '.', ''),
                'votes' => $quote->getNumberOfVotes(),
                'my_rating' => $quoteRating->rating,
            ];
        });

        return Inertia::render('MyRatings', [
            'quotes' => $quotes
        ]);
    }
}