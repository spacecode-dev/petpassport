<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('section')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');
            $table->unsignedBigInteger('album_id')->nullable();
            $table->text('description')->nullable();
            $table->string('thumb_180')->nullable();
            $table->string('thumb_360')->nullable();
            $table->string('thumb_720')->nullable();
            $table->string('thumb_1440')->nullable();
            $table->string('thumb_2880')->nullable();
            $table->string('original');
            $table->unsignedInteger('original_width');
            $table->unsignedInteger('original_height');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
