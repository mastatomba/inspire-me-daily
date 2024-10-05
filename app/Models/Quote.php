<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function createIdentifier(string $author, string $quote): string
    {
        return md5(str_replace(' ', '', ($author . '_' . $quote)));
    }
}
