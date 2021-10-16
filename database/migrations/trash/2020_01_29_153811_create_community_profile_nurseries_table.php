<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityProfileNurseriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_profile_nurseries', function (Blueprint $table) {
            $table->unsignedBigInteger('community_id');
            $table->text('history')->nullable();
            $table->string('certificate')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
        });

        $communities = \DB::table('communities')->where('type', 2)->get();

        foreach ($communities as $community) {
            \DB::table('community_profile_nurseries')->insert([
                'community_id' => $community->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_profile_nurseries');
    }
}
