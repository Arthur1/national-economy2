<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\CardSeries;
use App\Enums\CardType;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->enum('series', CardSeries::getValues())->index();
            $table->string('name');
            $table->integer('costs');
            $table->integer('vp');
            $table->string('text');
            $table->enum('type', CardType::getValues());
            $table->boolean('is_agriculture');
            $table->boolean('is_industry');
            $table->boolean('is_facility');
            $table->boolean('is_sellable');
            $table->integer('number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
