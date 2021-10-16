<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOwnerTypeToAnnouncements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->renameColumn('user_id', 'owner_id');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->string('owner_type')->after('owner_id'); 
        });

        \DB::table('announcements')->update([ 'owner_type' => 'profile' ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            //
        });
    }
}
