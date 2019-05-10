<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHitRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hit_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('mid')->comment('1文章2单页')->default(1);
            $table->unsignedInteger('catid')->comment('分类')->default(0);
            $table->unsignedInteger('aid')->comment('文档ID');
            $table->unsignedInteger('hits')->comment('点击数')->default(0);
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
        Schema::dropIfExists('hit_records');
    }
}
