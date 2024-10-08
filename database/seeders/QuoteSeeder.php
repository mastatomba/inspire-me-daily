<?php

namespace Database\Seeders;

use App\Models\Quote;
use App\Services\QuoteService;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertQuote("Stephen King", "Fear can hold you prisoner. Hope can set you free.");
        $this->insertQuote("Celestine Chua", "If you believe you can, you can. If you believe you can't, then, well you can't.");
        $this->insertQuote("Ralph Marston", "Greatness comes from living with purpose and passion.");
        $this->insertQuote("Steve Harvey", "Do not ignore the passion that burns in you. Spend time to discover your gift.");
        $this->insertQuote("Les Brown", "Fear does not have any special power unless you empower it by submitting to it.");
        $this->insertQuote("Robert F. Kennedy", "A hopeless man is a very desperate and dangerous man, almost a dead man.");
        $this->insertQuote("Eric Hoffer", "The search for happiness is one of the chief sources of unhappiness.");
        $this->insertQuote("Edgar Allan Poe", "The scariest monsters are the ones that lurk within our souls.");
        $this->insertQuote("Elvis Presley", "When things go wrong, don't go with them.");
        $this->insertQuote("Soren Kierkegaard", "Anxiety is the dizziness of freedom.");

        $quoteService = new QuoteService();
        for ($i = 0; $i < 3; $i++)
        {
            $quoteService->fetchQuotes();
            sleep(1);
        }
    }

    private function insertQuote(string $author, string $quote): void
    {
        Quote::create([
            'identifier' => Quote::createIdentifier($author, $quote),
            'author' => $author,
            'quote' => $quote
        ]);
    }
}
