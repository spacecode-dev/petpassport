<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('type');
            $table->unsignedBigInteger('wall_id');
            $table->string('wall_type');
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');
            $table->unsignedBigInteger('origin_id')->nullable();
            $table->text('body')->nullable();
            $table->unsignedTinyInteger('privacy')->nullable();
            $table->boolean('sos')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
