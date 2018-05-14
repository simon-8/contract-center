<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('pid')->comment('父ID')->default(0);
            $table->string('name')->comment('菜单名称');
            $table->string('route')->comment('路由名称')->default('');
            $table->string('link')->comment('目标链接')->default('');
            $table->string('ico')->comment('图标名称')->default('');
            $table->unsignedSmallInteger('listorder')->comment('排序')->default(0);
            $table->unsignedTinyInteger('items')->comment('子分类数量')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
