<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('order_id');
            $table->integer('product_id');
            $table->integer('qty')->default(1);
            $table->integer('address_id');
            $table->integer('evaluation')->default(-1);
            $table->float('delivery_fee')->default(0);
            $table->float('price')->default(0);
            $table->integer('status_id')->default(0);
            $table->float('payment_fee')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
