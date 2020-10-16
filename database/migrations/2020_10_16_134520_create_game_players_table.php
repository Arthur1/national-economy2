<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_players', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id');
            $table->integer('player_order');
            $table->bigInteger('user_id');
            $table->integer('money');
            $table->integer('debt')->default(0);
            $table->integer('vp_token')->default(0);
            $table->integer('workers_number')->default(2);
            $table->integer('dolls_number')->default(0);
            $table->integer('active_workers_number')->default(2);
            $table->integer('max_workers_number')->default(5);
            $table->integer('max_hand_cards_number')->default(5);
            $table->boolean('is_sp');
            $table->integer('vp')->nullable();
            $table->integer('rank')->nullable();
            $table->unique(['game_id', 'player_order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_players');
    }
}
