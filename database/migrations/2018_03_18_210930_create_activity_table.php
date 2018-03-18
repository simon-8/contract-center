<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('活动名称')->default('');
            $table->unsignedInteger('start_time')->comment('开始时间')->default(0);
            $table->unsignedInteger('end_time')->comment('结束时间/开奖时间')->default(0);
            $table->unsignedInteger('actor')->comment('参与人数')->default(0);
            $table->unsignedInteger('max_actor')->comment('参与人数限制')->default(0);
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
        Schema::dropIfExists('activity');
    }
}
