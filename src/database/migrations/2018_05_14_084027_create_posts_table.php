<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_posts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->string('excerpt');
            $table->text('content')->nullable();
            $table->boolean('published')->default(1);
            $table->integer('post_type_id')->index();
            $table->integer('post_parent_id')->index()->default(0);
            $table->integer('media_id')->index()->nullable();
            $table->integer('user_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_posts');
    }
}
