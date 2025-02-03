<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->increments("quiz_question_id");
            $table->integer('quiz_id')->unsigned();
            $table->foreign('quiz_id')->references('quiz_id')->on('quizzes')->onDelete('cascade');
            $table->text('question')->default(null);
            $table->text("option_1")->default(null);
            $table->text("option_2")->default(null);
            $table->text("option_3")->default(null);
            $table->text("option_4")->default(null);
            $table->text("correct_answer")->default(null);
            $table->text("marks")->default(null);
            $table->enum("question_status",["Active","Inactive"])->default("Active");
            $table->String("flag_count")->default(0);
            $table->String("topic_name")->default(null);
            $table->String("question_description")->default(null);
            $table->String("question_image")->default(null);
            $table->String("question_source")->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
