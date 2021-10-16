<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles2', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('type')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('name');
            $table->unsignedTinyInteger('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedTinyInteger('marital_status')->nullable();
            $table->text('about')->nullable();
            $table->string('site')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('noavatar')->default(false);
            $table->boolean('verified')->default(false);
            $table->boolean('mating')->default(false);
            $table->boolean('memory')->default(false);
            $table->bigInteger('rating')->default(0);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('birth_country_id')->nullable();
            $table->string('work_name')->nullable();
            $table->string('work_place')->nullable();
            $table->string('edu_name')->nullable();
            $table->string('edu_group')->nullable();
            $table->string('edu_degree')->nullable();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles2');
    }
}
