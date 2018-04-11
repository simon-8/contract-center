<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSinglePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_page', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('catid')->comment('分类ID')->default(0);
            $table->string('title')->comment('标题');
            $table->string('thumb')->comment('标题图片');
            $table->string('username')->comment('发布人');
            $table->unsignedInteger('comment')->comment('评论数量')->default(0);
            $table->unsignedInteger('zan')->comment('赞数量')->default(0);
            $table->unsignedBigInteger('hits')->comment('点击量')->default(0);
            $table->unsignedTinyInteger('status')->comment('状态')->default(0);
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
        Schema::dropIfExists('single_page');
    }
}
