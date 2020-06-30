<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('firstname_1')->nullable();
            $table->string('lastname_1')->nullable();
            $table->string('firstname_2')->nullable();
            $table->string('lastname_2')->nullable();
            $table->string('company')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('county')->nullable();
            $table->string('street')->nullable();
            $table->string('houst_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('postal_code')->nullable();
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
        Schema::dropIfExists('d_addresses');
    }
}
