<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveHasProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_has_product', function (Blueprint $table) {
            $table->id();
            $table->integer('live_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->integer('sold_qty')->default(0);
            $table->unique(['live_id', 'product_id']);
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
        Schema::dropIfExists('live_has_product');
    }
}
