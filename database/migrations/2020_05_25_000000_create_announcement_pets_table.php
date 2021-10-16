<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementPetsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_pets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('announcement_id');
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->unsignedTinyInteger('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('vetpassport')->default(false);
            $table->boolean('pedigree')->default(false);
            $table->boolean('contract')->default(false);
            $table->boolean('vaccination')->default(false);
            $table->boolean('mark')->default(false);
            $table->boolean('chip')->default(false);
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_pets');
    }
}
