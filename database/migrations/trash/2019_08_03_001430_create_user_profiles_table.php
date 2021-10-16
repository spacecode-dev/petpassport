<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->unsignedTinyInteger('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedTinyInteger('marital_status')->nullable();
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
        Schema::dropIfExists('user_profiles');
    }
}
