<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTypes extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->smallInteger('id');
            $table->string('name', 50);
            $table->string('description', 250)->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_types');
    }
}
