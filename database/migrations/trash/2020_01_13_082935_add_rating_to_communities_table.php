<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingToCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->bigInteger('rating')->default(0)->after('verified');
        });

        $members = \DB::table('community_members')->select('community_id')->get();

        foreach ($members as $member) {
            \DB::table('communities')->where('id', $member->community_id)->increment('rating');
        }

        $likes = \DB::table('likes')->select('object_id')->where('object_type', 'community')->get();

        foreach ($likes as $like) {
            \DB::table('communities')->where('id', $like->object_id)->increment('rating');
        }

        $posts = \DB::table('posts')->select('wall_id')->where('wall_type', 'community')->get();

        foreach ($posts as $post) {
            \DB::table('communities')->where('id', $post->wall_id)->increment('rating');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
}
