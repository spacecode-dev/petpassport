<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('official_name')->nullable();
            $table->unsignedTinyInteger('gender')->nullable();
            $table->unsignedBigInteger('type')->nullable();
            $table->date('birthday')->nullable();
            $table->string('weight')->nullable();
            $table->string('size')->nullable();
            $table->string('titles')->nullable();
            $table->string('inbreeding')->nullable();
            $table->string('korung')->nullable();
            $table->text('about')->nullable();
            $table->string('site')->nullable();
            $table->string('avatar')->nullable();
            $table->string('background')->nullable();
            $table->boolean('verified')->default(false);
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
        Schema::dropIfExists('pet_profiles');
    }
}
