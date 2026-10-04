<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos', function (Blueprint $table) {
            $table->bigIncrements('pos_id');
            $table->string('name')->nullable()->default(null);
            $table->string('username')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->enum('account_Status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos');
    }
};
