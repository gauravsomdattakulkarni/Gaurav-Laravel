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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->nullable()->default(null);
            $table->string('book_name')->nullable()->default(null);
            $table->string('author_name')->nullable()->default(null);
            $table->string('category')->nullable()->default(null);
            $table->string('publisher')->nullable()->default(null);
            $table->year('publication_year')->nullable()->default(null);
            $table->string('edition')->nullable()->default(null);
            $table->string('cover_image')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->string('total_copies')->nullable()->default(0);
            $table->string('avaliable_copies')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
