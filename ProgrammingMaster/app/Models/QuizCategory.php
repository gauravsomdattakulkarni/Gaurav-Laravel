<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizCategory extends Model
{
    protected $primaryKey = 'quiz_category_id';
    protected $fillable = ['category_name', 'category_status'];

    public $incrementing = true;
    protected $keyType = 'int';
}
