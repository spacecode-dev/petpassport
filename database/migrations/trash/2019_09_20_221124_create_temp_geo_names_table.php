<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempGeoNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_geo_names', function (Blueprint $table) {
            $table->string('lang');
            $table->string('name');
            $table->unsignedBigInteger('geonameid');
            $table->unsignedBigInteger('alternatenameid');
            $table->boolean('preferred')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_geo_names');
    }
}
