<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryApplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_apply', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aid')->comment('活动ID');
            $table->string('userid')->comment('userid');
            $table->string('truename')->comment('姓名');
            $table->string('mobile')->comment('手机号');
            $table->timestamps();

            // 同个活动一个手机只能参加一次
            $table->unique([
                'aid',
                'userid'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_apply');
    }
}
