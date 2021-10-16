<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_names', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id');
            $table->string('lang');
            $table->string('name');
            $table->unsignedBigInteger('geonameid');
            $table->unsignedBigInteger('alternatenameid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_names');
    }
}
