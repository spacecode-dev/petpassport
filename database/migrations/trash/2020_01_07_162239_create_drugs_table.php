<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('type')->nullable();
            $table->date('date')->nullable();
            $table->string('drug')->nullable();
            $table->string('batch')->nullable();
            $table->string('dose')->nullable();
            $table->string('doctor')->nullable();
            $table->string('comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drugs');
    }
}
