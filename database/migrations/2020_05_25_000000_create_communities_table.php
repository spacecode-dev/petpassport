<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunitiesTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('type');
            $table->string('slug')->nullable();
            $table->string('name');
            $table->boolean('verified')->default(false);
            $table->bigInteger('rating')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities');
    }
}
