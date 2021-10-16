<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSearchIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Config::get('database.default')=='pgsql') {
            DB::statement('ALTER TABLE announcements ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX announcements_searchable_index ON announcements USING GIN (searchable)');

            DB::statement('ALTER TABLE comments ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX comments_searchable_index ON comments USING GIN (searchable)');

            DB::statement('ALTER TABLE communities ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX communities_searchable_index ON communities USING GIN (searchable)');

            DB::statement('ALTER TABLE community_events ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX community_events_searchable_index ON community_events USING GIN (searchable)');

            DB::statement('ALTER TABLE community_profile_breeds ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX community_profile_breeds_searchable_index ON community_profile_breeds USING GIN (searchable)');

            DB::statement('ALTER TABLE community_profile_nurseries ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX community_profile_nurseries_searchable_index ON community_profile_nurseries USING GIN (searchable)');

            DB::statement('ALTER TABLE messages ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX messages_searchable_index ON messages USING GIN (searchable)');

            DB::statement('ALTER TABLE pet_profiles ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX pet_profiles_searchable_index ON pet_profiles USING GIN (searchable)');

            DB::statement('ALTER TABLE posts ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX posts_searchable_index ON posts USING GIN (searchable)');

            DB::statement('ALTER TABLE reviews ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX reviews_searchable_index ON reviews USING GIN (searchable)');

            DB::statement('ALTER TABLE shops ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX shops_searchable_index ON shops USING GIN (searchable)');

            DB::statement('ALTER TABLE user_profiles ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX user_profiles_searchable_index ON user_profiles USING GIN (searchable)');

            DB::statement('ALTER TABLE users ADD searchable tsvector NULL');
            DB::statement('CREATE INDEX users_searchable_index ON users USING GIN (searchable)');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Config::get('database.default')=='pgsql') {
            Schema::table('announcements',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('comments',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('communities',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('community_events',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('community_profile_breeds',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('community_profile_nurseries',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('messages',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('pet_profiles',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('posts',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('reviews',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('shops',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('user_profiles',function (Blueprint $table){
                $table->dropColumn('searchable');
            });

            Schema::table('users',function (Blueprint $table){
                $table->dropColumn('searchable');
            });
        }
    }
}
