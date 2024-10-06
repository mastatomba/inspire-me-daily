<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'identifier',
        'author',
        'quote',
    ];

    /**
     * Get the ratings
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(QuoteRating::class);
    }

    public function getNumberOfVotes(): int
    {
        return $this->ratings->count();
    }

    public function calculateRating(): float
    {
        $ratings = $this->ratings;
        if ($ratings->count() === 0)
        {
            return 0.0;
        }

        $total_rating = 0;
        foreach($ratings as $rating)
        {
            $total_rating += $rating->rating;
        }
        return $total_rating / $ratings->count();
    }

    public static function createIdentifier(string $author, string $quote): string
    {
        return md5(str_replace(' ', '', ($author . '_' . $quote)));
    }
}
