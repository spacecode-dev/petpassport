<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('type');
            $table->unsignedBigInteger('wall_id');
            $table->unsignedTinyInteger('wall_type');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedTinyInteger('owner_type');
            $table->unsignedBigInteger('origin_id')->nullable();
            $table->unsignedTinyInteger('origin_type')->nullable();
            $table->text('body')->nullable();
            $table->unsignedTinyInteger('privacy')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
