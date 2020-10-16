<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_buildings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id');
            $table->bigInteger('card_id');
            $table->integer('own_player_order')->nullable();
            $table->integer('origin_own_player_order')->nullable();
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
        Schema::dropIfExists('game_buildings');
    }
}
