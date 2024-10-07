<?php

namespace Tests\Feature\Model;

use App\Models\Quote;
use App\Models\QuoteRating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_rating(): void
    {
        $this->insertAndTestQuoteRatings([], 0.0);
        $this->insertAndTestQuoteRatings([1, 1, 1], 1.0);
        $this->insertAndTestQuoteRatings([2, 2, 2, 2], 2.0);
        $this->insertAndTestQuoteRatings([3, 3, 2, 2], 2.5);
        $this->insertAndTestQuoteRatings([4, 4, 4, 3], 3.75);
        $this->insertAndTestQuoteRatings([5, 5, 4, 4, 3, 3], 4.0);
    }

    public function test_get_user_rating(): void
    {
        $quote = Quote::factory()->create();
        $user = User::factory()->create();

        $this->assertEquals(0, $quote->getUserRating($user->id));

        $this->insertQuoteRating($user->id, $quote->id, 3);

        $this->assertEquals(3, $quote->getUserRating($user->id));

        $user = User::factory()->create();
        $this->insertQuoteRating($user->id, $quote->id, 4);

        $this->assertEquals(4, $quote->getUserRating($user->id));
    }

    private function insertAndTestQuoteRatings(array $userRatings, float $expectedRating)
    {
        $quote = Quote::factory()->create();

        for ($i = 0; $i < count($userRatings); $i++)
        {
            $user = User::factory()->create();
            $this->insertQuoteRating($user->id, $quote->id, $userRatings[$i]);
        }

        $this->assertEquals($expectedRating, $quote->calculateRating());
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
