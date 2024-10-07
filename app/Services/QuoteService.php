<?php

namespace App\Services;

use App\Models\Quote;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuoteService
{
    private const ZENQUOTES_API_BASE_URL = "https://zenquotes.io/api";

    public function getRandomQuote(): Quote
    {
        return Quote::inRandomOrder()->first();
    }

    public function getTopRatedQuotes(int $count): Collection
    {
        // use with() to eager load the ratings
        $quotes = Quote::with('ratings')->get();
        // sort descendingly on ratings and if ratings are equal, take number of votes into account
        $sorted_quotes = $quotes->sortBy([
            fn (Quote $a, Quote $b) => $b->calculateRating() <=> $a->calculateRating(),
            fn (Quote $a, Quote $b) => $b->getNumberOfVotes() <=> $a->getNumberOfVotes(),
        ]);
        // use values() to reindex the sorted array and slice() to limit the results
        return $sorted_quotes->values()->slice(0, $count);
    }

    /**
     * Fetch 50 random quotes from zenquotes api. The response will be in json format:
     * [
     *   {
     *     "q": "Fear can hold you prisoner. Hope can set you free.",
     *     "a": "Stephen King",
     *     "c": "50",
     *     "h": "<blockquote>&ldquo;Fear can hold you prisoner. Hope can set you free.&rdquo; &mdash; <footer>Stephen King</footer></blockquote>"
     *   },
     *   {
     *     "q": "If you believe you can, you can. If you believe you can't, then, well you can't.",
     *     "a": "Celestine Chua",
     *     "c": "80",
     *     "h": "<blockquote>&ldquo;If you believe you can, you can. If you believe you can't, then, well you can't.&rdquo; &mdash; <footer>Celestine Chua</footer></blockquote>"
     *   }
     * ]
     * 
     * Important keys that we can use:
     * q = quote text
     * a = author name
     */
    public function fetchQuotes(): void
    {
        Log::info("Fetching new quotes from zenquotes api.");
        try
        {
            $response = Http::timeout(10)->get(self::ZENQUOTES_API_BASE_URL . "/quotes");
            if ($response->successful())
            {
                $currentIdentifiers = Quote::pluck('identifier')->toArray();
                $insertedCount = $skippedCount = 0;

                $quotes = $response->json();
                Log::debug("We got a response.", ['quotes' => $quotes]);
                foreach ($quotes as $quote)
                {
                    $author = $quote['a'];
                    $quote = $quote['q'];
                    $identifier = Quote::createIdentifier($author, $quote);

                    if (!in_array($identifier, $currentIdentifiers, true))
                    {
                        $quoteId = Quote::create([
                            'identifier' => $identifier,
                            'author' => $author,
                            'quote' => $quote
                        ]);
                        $currentIdentifiers[] = $identifier;

                        Log::debug("Inserted a new quote with id {$quoteId}.", ['identifier' => $identifier, 'author' => $author, 'quote' => $quote]);
                        $insertedCount++;
                    }
                    else
                    {
                        Log::debug("Skipped existing quote.", ['author' => $author, 'quote' => $quote]);
                        $skippedCount++;
                    }
                }
                Log::info("Successfully fetched new quotes.", ['insertedCount' => $insertedCount, 'skippedCount' => $skippedCount]);
            }
            else
            {
                $response->throw();
            }
        }
        catch (\Exception $e)
        {
            Log::error("Error occured during fetching of new quotes: " . $e->getMessage());
        }
    }
}
