<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRating extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'quote_id',
        'rating',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quote
     */
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public static function createIdentifier(string $author, string $quote): string
    {
        return md5(str_replace(' ', '', ($author . '_' . $quote)));
    }
}
