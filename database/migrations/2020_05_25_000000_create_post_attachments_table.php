<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostAttachmentsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('post_attachments', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('attachment_id')->nullable();
            $table->string('attachment_type')->nullable();
            $table->text('data')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_attachments');
    }
}
