<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestions extends Model
{
    protected $fillable = [
        'quiz_question_id',
        'quiz_id',
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'correct_answer',
        'marks',
        'question_status',
        'flag_count',
        'topic_name',
        'question_description',
        'question_image',
        'question_source'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }
}
