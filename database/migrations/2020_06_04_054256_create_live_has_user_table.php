<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveHasUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_has_user', function (Blueprint $table) {
            $table->id();
            $table->integer('live_id');
            $table->integer('user_id');
            $table->integer('watch_status_id');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('live_id')->references('id')->on('lives');
            //$table->unique(['live_id', 'user_id']);
            $table->timestamps();
        });

        Schema::table('live_has_user', function($table) {
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('live_id')->references('id')->on('lives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_has_user');
    }
}
