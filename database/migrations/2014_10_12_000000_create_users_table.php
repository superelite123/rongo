<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('firstname_h')->nullable();
            $table->string('lastname_h')->nullable();
            $table->string('firstname_k')->nullable();
            $table->string('lastname_k')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('token_2fa')->nullable();
            $table->datetime('token_2fa_expiry')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->Integer('address_id')->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}
