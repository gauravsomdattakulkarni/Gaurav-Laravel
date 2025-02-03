<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;
use App\Mail\OtpVerification;
use Illuminate\Http\Request;
use App\Models\EncryptionModel;
use App\Models\Admin;
use App\Models\Book;
use App\Models\BookQuantity;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Throwable;


class Quiz extends Model
{
    public function questions()
    {
        return $this->hasMany(QuizQuestions::class, 'quiz_id', 'id');
    }
}
