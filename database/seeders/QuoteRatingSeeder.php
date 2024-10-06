<?php

namespace Database\Seeders;

use App\Models\Quote;
use App\Models\QuoteRating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $quote_ids = Quote::all()->pluck('id')->toArray();

        $data = [];
        foreach($quote_ids as $quote_id)
        {
            $count = random_int(1, count($user_ids));
            for ($i = 0; $i < $count; $i++)
            {
                $data[] = [
                    'user_id' => $user_ids[$i],
                    'quote_id' => $quote_id,
                    'rating' => random_int(2, 5)
                ];
            }
        }
        
        QuoteRating::insert($data);
    }
}
