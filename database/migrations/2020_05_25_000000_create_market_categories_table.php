<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketCategoriesTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('market_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_categories');
    }
}
