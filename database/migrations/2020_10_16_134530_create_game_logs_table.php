<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\LogType;
use App\Enums\ActionType;

class CreateGameLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id');
            $table->integer('player_order');
            $table->integer('round');
            $table->enum('type', LogType::getValues());
            $table->integer('building_id')->nullable();
            $table->enum('action_type', ActionType::getValues())->nullable();
            $table->boolean('is_done');
            $table->string('text');
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
        Schema::dropIfExists('game_logs');
    }
}
