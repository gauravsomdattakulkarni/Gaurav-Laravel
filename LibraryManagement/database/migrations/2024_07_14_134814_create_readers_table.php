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
        Schema::create('readers', function (Blueprint $table) {
            $table->id();
            $table->text('user_id')->nullable()->default(null);
            $table->text('first_name')->nullable()->default(null);
            $table->text('last_name')->nullable()->default(null);
            $table->text('email')->nullable()->default(null);
            $table->text('mobile')->nullable()->default(null);
            $table->date('date_of_birth')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->text('pincode')->nullable()->default(null);
            $table->enum('membership_status',['active','inactive'])->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readers');
    }
};
