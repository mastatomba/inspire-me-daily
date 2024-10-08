<?php

namespace Tests\Feature\Service;

use App\Models\Quote;
use App\Models\QuoteRating;
use App\Models\User;
use App\Services\QuoteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteServiceTest extends TestCase
{
    use RefreshDatabase;

    private QuoteService $quoteService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->quoteService = new QuoteService();
    }

    public function test_get_top_rated_quotes(): void
    {
        $quote1 = $this->insertQuoteAndRatings([3, 3, 3]); // 3.0
        $quote2 = $this->insertQuoteAndRatings([4, 4, 4]); // 4.0

        $top_quotes = $this->quoteService->getTopRatedQuotes(2);

        $this->assertCount(2, $top_quotes);
        $this->assertEquals($quote2->id, $top_quotes[0]->id); // 4.0
        $this->assertEquals($quote1->id, $top_quotes[1]->id); // 3.0

        $quote3 = $this->insertQuoteAndRatings([4, 4, 5, 5]); // 4.5
        $quote4 = $this->insertQuoteAndRatings([2, 3]); // 2.5

        $top_quotes = $this->quoteService->getTopRatedQuotes(4);

        $this->assertCount(4, $top_quotes);
        $this->assertEquals($quote3->id, $top_quotes[0]->id); // 4.5
        $this->assertEquals($quote2->id, $top_quotes[1]->id); // 4.0
        $this->assertEquals($quote1->id, $top_quotes[2]->id); // 3.0
        $this->assertEquals($quote4->id, $top_quotes[3]->id); // 2.5

        $quote5 = $this->insertQuoteAndRatings([1, 2, 3, 4, 5]); // 3.0
        $quote6 = $this->insertQuoteAndRatings([3, 4, 3, 4, 3, 4]); // 3.5

        $top_quotes = $this->quoteService->getTopRatedQuotes(5);

        $this->assertCount(5, $top_quotes);
        $this->assertEquals($quote3->id, $top_quotes[0]->id); // 4.5
        $this->assertEquals($quote2->id, $top_quotes[1]->id); // 4.0
        $this->assertEquals($quote6->id, $top_quotes[2]->id); // 3.5
        $this->assertEquals($quote5->id, $top_quotes[3]->id); // 3.0
        $this->assertEquals($quote1->id, $top_quotes[4]->id); // 3.0
    }

    public function test_get_quotes_rated_by_user(): void
    {
        //getQuotesRatedByUser
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $quote1 = Quote::factory()->create();
        $quote2 = Quote::factory()->create();
        $quote3 = Quote::factory()->create();
        $quote4 = Quote::factory()->create();
        $quote5 = Quote::factory()->create();
        $quote6 = Quote::factory()->create();
        $quote7 = Quote::factory()->create();
        $quote8 = Quote::factory()->create();
        $quote9 = Quote::factory()->create();

        $this->insertQuoteRating($user1->id, $quote1->id, 3);
        $this->insertQuoteRating($user1->id, $quote3->id, 4);
        $this->insertQuoteRating($user1->id, $quote5->id, 5);
        $this->insertQuoteRating($user1->id, $quote7->id, 2);
        $this->insertQuoteRating($user1->id, $quote8->id, 5);
        $this->insertQuoteRating($user1->id, $quote9->id, 4);

        $this->insertQuoteRating($user2->id, $quote2->id, 3);
        $this->insertQuoteRating($user2->id, $quote4->id, 2);
        $this->insertQuoteRating($user2->id, $quote6->id, 4);

        $quotes = $this->quoteService->getQuotesRatedByUser($user1->id);

        $this->assertCount(6, $quotes);
        $this->assertEquals($quote5->id, $quotes[0]->quote_id);
        $this->assertEquals($quote8->id, $quotes[1]->quote_id);
        $this->assertEquals($quote3->id, $quotes[2]->quote_id);
        $this->assertEquals($quote9->id, $quotes[3]->quote_id);
        $this->assertEquals($quote1->id, $quotes[4]->quote_id);
        $this->assertEquals($quote7->id, $quotes[5]->quote_id);

        $quotes = $this->quoteService->getQuotesRatedByUser($user2->id);

        $this->assertCount(3, $quotes);
        $this->assertEquals($quote6->id, $quotes[0]->quote_id);
        $this->assertEquals($quote2->id, $quotes[1]->quote_id);
        $this->assertEquals($quote4->id, $quotes[2]->quote_id);

        $quotes = $this->quoteService->getQuotesRatedByUser($user3->id);

        $this->assertCount(0, $quotes);
    }

    private function insertQuoteAndRatings(array $userRatings): Quote
    {
        $quote = Quote::factory()->create();

        for ($i = 0; $i < count($userRatings); $i++)
        {
            $user = User::factory()->create();
            $this->insertQuoteRating($user->id, $quote->id, $userRatings[$i]);
        }

        return $quote;
    }

    private function insertQuoteRating(int $user_id, int $quote_id, int $rating): QuoteRating
    {
        return QuoteRating::create([
            'user_id' => $user_id,
            'quote_id' => $quote_id,
            'rating' => $rating
        ]);
    }
}
