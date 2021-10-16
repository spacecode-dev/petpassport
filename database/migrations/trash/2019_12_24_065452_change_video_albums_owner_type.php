<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVideoAlbumsOwnerType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_albums', function (Blueprint $table) {
            $table->dropColumn('owner_type');
        });

        Schema::table('video_albums', function (Blueprint $table) {
            $table->string('owner_type')->after('owner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
