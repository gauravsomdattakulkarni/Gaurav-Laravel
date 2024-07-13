<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['isbn', 'book_name', 'author_name', 'category', 'publisher', 'publication_year', 'edition', 'cover_image', 'description'];

    public function quantities()
    {
        return $this->hasMany(BookQuantity::class);
    }

    
    use HasFactory;
}
