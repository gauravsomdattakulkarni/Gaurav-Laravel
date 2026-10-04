<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_code')->unique();
            $table->string('product_name');
            $table->decimal('product_price', 10, 2);
            $table->decimal('product_discount_amount', 10, 2)->default(0);
            $table->decimal('product_price_after_discount', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};