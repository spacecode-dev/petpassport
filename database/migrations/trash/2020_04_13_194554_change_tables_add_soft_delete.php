<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTablesAddSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('communities', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('community_events', function (Blueprint $table) {
            $table->softDeletes();
        });


        Schema::table('announcements', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('user_friends', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('announcement_pets', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('announcement_photos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('user_shops', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('video_albums', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('communities', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('community_events', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('user_friends', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('announcement_pets', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('announcement_photos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('user_shops', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('video_albums', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
