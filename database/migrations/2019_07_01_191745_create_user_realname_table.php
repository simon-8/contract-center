<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRealnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_realname', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('userid');
            $table->string('truename')->default('')->comment('姓名');
            $table->string('nationality')->default('')->comment('民族');
            $table->string('idcard')->default('')->comment('身份证号');
            $table->string('sex')->default('')->comment('性别');
            $table->string('birth')->default('')->comment('出生日期');
            $table->string('address')->default('')->comment('地址信息');
            $table->string('start_date')->default('')->comment('有效期起始时间');
            $table->string('end_date')->default('')->comment('有效期结束时间');
            $table->string('issue')->default('')->comment('签发机关');

            $table->string('face_img')->default('')->comment('身份证正面图片');
            $table->string('back_img')->default('')->comment('身份证反面图片');

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
        Schema::dropIfExists('user_realname');
    }
}
