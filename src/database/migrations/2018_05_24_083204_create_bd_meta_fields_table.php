<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdMetaFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_meta_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('type');
            $table->string('class')->nullable();
            $table->longtext('options')->nullable();
            $table->integer('order')->default(1);
            $table->boolean('required')->default(0);
            $table->integer('meta_group_id')->index();
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
        Schema::dropIfExists('bd_meta_fields');
    }
}
