<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_menu_items', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('label');
            $table->string('url');
            $table->integer('order');
            $table->integer('parent')->default(0);
            $table->integer('bd_menu_id')->index();
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
        Schema::dropIfExists('bd_menu_items');
    }
}
