<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetProfilesTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('pet_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('breeder_id')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('nursery_id')->nullable();
            $table->unsignedBigInteger('born_nursery_id')->nullable();
            $table->string('name');
            $table->string('home_name')->nullable();
            $table->unsignedTinyInteger('gender')->nullable();
            $table->unsignedBigInteger('pet_type');
            $table->date('birthday')->nullable();
            $table->string('weight')->nullable();
            $table->string('size')->nullable();
            $table->text('titles')->nullable();
            $table->string('inbreeding')->nullable();
            $table->string('korung')->nullable();
            $table->boolean('mating')->default(false);
            $table->boolean('info_hidden')->default(false);
            $table->text('about')->nullable();
            $table->string('site')->nullable();
            $table->string('avatar')->nullable();
            $table->string('background')->nullable();
            $table->boolean('verified')->default(false);
            $table->boolean('memory')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pet_profiles');
    }
}
