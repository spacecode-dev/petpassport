<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Comment;
use App\Models\Like;

class PolymorphicRefactoring extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('object_id');
            $table->string('object_type');
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');
            $table->text('body')->nullable();
            $table->timestamps();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('object_id');
            $table->string('object_type');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        $photo_comments = \DB::table('photo_comments')->get();

        foreach ($photo_comments as $photo_comment) {
            $new_comment = new Comment;
            $new_comment->object_id = $photo_comment->photo_id;
            $new_comment->object_type = 'photo';
            $new_comment->owner_id = $photo_comment->owner_id;
            $new_comment->owner_type = $photo_comment->owner_type;
            $new_comment->body = $photo_comment->body;
            $new_comment->created_at = $photo_comment->created_at;
            $new_comment->updated_at = $photo_comment->updated_at;
            $new_comment->save();

            $photo_comment_likes = \DB::table('photo_comment_likes')->where('comment_id', $photo_comment->id)->get();

            foreach ($photo_comment_likes as $photo_comment_like) {
                $new_like = new Like;
                $new_like->object_id = $new_comment->id;
                $new_like->object_type = 'comment';
                $new_like->user_id = $photo_comment_like->user_id;
                $new_like->created_at = $photo_comment_like->created_at;
                $new_like->updated_at = $photo_comment_like->updated_at;
                $new_like->save();
            }
        }

        Schema::dropIfExists('photo_comments');
        Schema::dropIfExists('photo_comment_likes');

        $photo_likes = \DB::table('photo_likes')->get();

        foreach ($photo_likes as $photo_like) {
            $new_like = new Like;
            $new_like->object_id = $photo_like->photo_id;
            $new_like->object_type = 'photo';
            $new_like->user_id = $photo_like->user_id;
            $new_like->created_at = $photo_like->created_at;
            $new_like->updated_at = $photo_like->updated_at;
            $new_like->save();
        }

        Schema::dropIfExists('photo_likes');

        $post_comments = \DB::table('post_comments')->get();

        foreach ($post_comments as $post_comment) {
            $new_comment = new Comment;
            $new_comment->object_id = $post_comment->post_id;
            $new_comment->object_type = 'post';
            $new_comment->owner_id = $post_comment->owner_id;
            $new_comment->owner_type = $post_comment->owner_type;
            $new_comment->body = $post_comment->body;
            $new_comment->created_at = $post_comment->created_at;
            $new_comment->updated_at = $post_comment->updated_at;
            $new_comment->save();

            $post_comment_likes = \DB::table('post_comment_likes')->where('comment_id', $post_comment->id)->get();

            foreach ($post_comment_likes as $post_comment_like) {
                $new_like = new Like;
                $new_like->object_id = $new_comment->id;
                $new_like->object_type = 'comment';
                $new_like->user_id = $post_comment_like->user_id;
                $new_like->created_at = $post_comment_like->created_at;
                $new_like->updated_at = $post_comment_like->updated_at;
                $new_like->save();
            }
        }

        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('post_comment_likes');

        $post_likes = \DB::table('post_likes')->get();

        foreach ($post_likes as $post_like) {
            $new_like = new Like;
            $new_like->object_id = $post_like->post_id;
            $new_like->object_type = 'post';
            $new_like->user_id = $post_like->user_id;
            $new_like->created_at = $post_like->created_at;
            $new_like->updated_at = $post_like->updated_at;
            $new_like->save();
        }

        Schema::dropIfExists('post_likes');

        $announcement_likes = \DB::table('announcement_likes')->get();

        foreach ($announcement_likes as $announcement_like) {
            $new_like = new Like;
            $new_like->object_id = $announcement_like->announcement_id;
            $new_like->object_type = 'announcement';
            $new_like->user_id = $announcement_like->user_id;
            $new_like->created_at = $announcement_like->created_at;
            $new_like->updated_at = $announcement_like->updated_at;
            $new_like->save();
        }

        Schema::dropIfExists('announcement_likes');

        $community_likes = \DB::table('community_likes')->get();

        foreach ($community_likes as $community_like) {
            $new_like = new Like;
            $new_like->object_id = $community_like->community_id;
            $new_like->object_type = 'community';
            $new_like->user_id = $community_like->user_id;
            $new_like->created_at = $community_like->created_at;
            $new_like->updated_at = $community_like->updated_at;
            $new_like->save();
        }

        Schema::dropIfExists('community_likes');
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
