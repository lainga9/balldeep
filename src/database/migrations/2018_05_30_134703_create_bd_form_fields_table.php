<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label')->default('Untitled');
            $table->string('type');
            $table->longtext('options')->nullable();
            $table->boolean('required')->default(0);
            $table->integer('order');
            $table->longtext('meta')->nullable();
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
        Schema::dropIfExists('bd_form_fields');
    }
}
