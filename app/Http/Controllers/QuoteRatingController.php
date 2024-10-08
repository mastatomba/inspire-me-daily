<?php

namespace App\Http\Controllers;

use App\Models\QuoteRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteRatingController extends Controller
{
    /**
     * Update or create the quote rating
     */
    public function updateOrCreate(Request $request)
    {
        QuoteRating::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'quote_id' => $request->quote_id
            ],
            [
                'rating' => $request->rating
            ]
        );

        return to_route('quote.show', ['id' => $request->quote_id]);
    }
}