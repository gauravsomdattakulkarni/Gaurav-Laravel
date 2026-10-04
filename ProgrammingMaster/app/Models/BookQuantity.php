<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookQuantity extends Model
{
    protected $fillable = ['book_id', 'quantity', 'acquisition_type', 'acquisition_date', 'notes'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    
    use HasFactory;
}
