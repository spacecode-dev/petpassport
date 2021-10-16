<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('type')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');
            $table->unsignedTinyInteger('from')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedTinyInteger('currency')->nullable();
            $table->boolean('bargain')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('views_today')->default(0);
            $table->timestamp('colored_until')->nullable();
            $table->timestamp('pinned_until')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
