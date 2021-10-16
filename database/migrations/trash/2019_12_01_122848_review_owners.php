<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReviewOwners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('user_reviews', 'reviews');

        Schema::table('reviews', function (Blueprint $table) {
            $table->renameColumn('owner_id', 'temp_owner_id');
            $table->renameColumn('user_id', 'temp_user_id');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->renameColumn('temp_owner_id', 'user_id');
            $table->renameColumn('temp_user_id', 'owner_id');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->string('owner_type')->after('owner_id'); 
        });

        \DB::table('reviews')->update([
            'owner_type' => 'profile'
        ]);
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
