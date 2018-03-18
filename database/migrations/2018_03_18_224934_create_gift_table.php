<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aid')->comment('指定活动ID')->default(0);
            $table->string('name')->comment('奖品名称')->default('');
            $table->string('introduce')->comment('奖品简介')->default('');
            $table->string('thumb')->comment('缩略图')->default('');
            $table->unsignedInteger('amount')->comment('库存')->default(0);
            $table->unsignedInteger('sales')->comment('已兑换次数')->default(0);
            $table->unsignedTinyInteger('status')->comment('奖品状态')->default(0);
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
        Schema::dropIfExists('gifts');
    }
}
