<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOwnerType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('wall_type')->change();
            $table->string('owner_type')->change();
        });

        \DB::table('posts')->where('owner_type', '1')->update([ 'owner_type' => 'profile' ]);
        \DB::table('posts')->where('owner_type', '2')->update([ 'owner_type' => 'community' ]);
        \DB::table('posts')->where('wall_type', '1')->update([ 'wall_type' => 'profile' ]);
        \DB::table('posts')->where('wall_type', '2')->update([ 'wall_type' => 'community' ]);

        Schema::table('post_comments', function (Blueprint $table) {
            $table->string('owner_type')->change();
        });

        \DB::table('post_comments')->where('owner_type', '1')->update([ 'owner_type' => 'profile' ]);
        \DB::table('post_comments')->where('owner_type', '2')->update([ 'owner_type' => 'community' ]);

        Schema::table('photos', function (Blueprint $table) {
            $table->string('owner_type')->change();
        });

        \DB::table('photos')->where('owner_type', '1')->update([ 'owner_type' => 'profile' ]);
        \DB::table('photos')->where('owner_type', '2')->update([ 'owner_type' => 'community' ]);

        Schema::table('photo_comments', function (Blueprint $table) {
            $table->string('owner_type')->change();
        });

        \DB::table('photo_comments')->where('owner_type', '1')->update([ 'owner_type' => 'profile' ]);
        \DB::table('photo_comments')->where('owner_type', '2')->update([ 'owner_type' => 'community' ]);

        Schema::table('photo_albums', function (Blueprint $table) {
            $table->string('owner_type')->change();
        });

        \DB::table('photo_albums')->where('owner_type', '1')->update([ 'owner_type' => 'profile' ]);
        \DB::table('photo_albums')->where('owner_type', '2')->update([ 'owner_type' => 'community' ]);

        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->string('wall_type')->change();
        });

        \DB::table('user_subscriptions')->where('wall_type', '1')->update([ 'wall_type' => 'profile' ]);
        \DB::table('user_subscriptions')->where('wall_type', '2')->update([ 'wall_type' => 'community' ]);
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
