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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->increments('quiz_id');
            $table->String('quiz_title');
            $table->text('quiz_description');
            $table->text('quiz_image');
            $table->enum('difficulty_level',["Easy","Medium","Difficult"]);
            $table->enum('negative_marking',["Yes","No"])->default("Yes");
            $table->String('quiz_category');
            $table->String('programming_language');
            $table->enum('quiz_status',["Active","InActive"])->default("Active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
