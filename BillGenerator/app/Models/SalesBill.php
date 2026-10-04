<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesBill extends Model
{
    use HasFactory;

    protected $primaryKey = 'bill_id';

    protected $fillable = [
        'total_amount',
        'total_items',
        'items_data'
    ];

    protected $casts = [
        'items_data' => 'array'
    ];
}