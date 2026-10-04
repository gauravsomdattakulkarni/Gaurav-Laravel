<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales_bills', function (Blueprint $table) {
            $table->id('bill_id');
            $table->decimal('total_amount', 10, 2);
            $table->integer('total_items');
            $table->json('items_data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_bills');
    }
};