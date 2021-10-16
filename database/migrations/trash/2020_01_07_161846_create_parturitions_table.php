<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParturitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parturitions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->date('heat_date')->nullable();
            $table->date('pairing_date')->nullable();
            $table->date('parturition_date')->nullable();
            $table->string('litter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parturitions');
    }
}
