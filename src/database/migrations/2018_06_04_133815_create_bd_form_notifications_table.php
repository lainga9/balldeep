<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdFormNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_form_notifications', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('subject');
            $table->longtext('content');
            $table->string('email');
            $table->boolean('active')->default(1);
            $table->integer('form_id')->index();
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
        Schema::dropIfExists('bd_form_notifications');
    }
}
