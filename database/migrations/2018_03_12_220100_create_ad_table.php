<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pid')->comment('所属广告位ID')->default(0);
            $table->string('thumb')->comment('图片')->default('');
            $table->string('url')->comment('外链地址')->default('');
            $table->string('title')->comment('图片名称')->default('');
            $table->string('content')->comment('文字介绍')->default('');
            $table->unsignedInteger('listorder')->comment('排序')->default(0);
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
        Schema::dropIfExists('ad');
    }
}
