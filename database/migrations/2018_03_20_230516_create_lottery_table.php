<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('apply_id')->comment('apply表ID');
            $table->unsignedInteger('userid')->comment('用户ID');
            $table->unsignedInteger('aid')->comment('活动ID');
            $table->unsignedInteger('gid')->comment('奖品ID');
            $table->string('gname')->comment('奖品名称');
            $table->string('truename')->comment('姓名');
            $table->string('mobile')->comment('手机');
            $table->unsignedInteger('admin_userid')->comment('操作管理员用户ID');
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
        Schema::dropIfExists('lottery');
    }
}
