<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityProfileBreedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_profile_breeds', function (Blueprint $table) {
            $table->unsignedBigInteger('community_id');
            $table->text('history')->nullable();
            $table->text('standard')->nullable();
            $table->text('terminology')->nullable();
        });

        $communities = \DB::table('communities')->where('type', 4)->get();

        foreach ($communities as $community) {
            \DB::table('community_profile_breeds')->insert([
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
        Schema::dropIfExists('community_profile_breeds');
    }
}
