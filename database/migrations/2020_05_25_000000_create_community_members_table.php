<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityMembersTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::create('community_members', function (Blueprint $table) {
            $table->unsignedBigInteger('community_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_members');
    }
}
