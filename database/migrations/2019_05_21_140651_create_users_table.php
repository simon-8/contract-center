<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->default('')->comment('用户名');
            $table->string('password')->default('')->comment('密码');
            $table->string('nickname')->default('')->comment('昵称');
            $table->string('truename')->default('')->comment('真实姓名');
            $table->string('mobile', 15)->default('')->comment('手机号码');
            $table->string('email')->default('')->comment('email');
            $table->unsignedDecimal('money')->default(0)->comment('余额');
            $table->string('country')->default('')->comment('国家');
            $table->string('province')->default('')->comment('省份');
            $table->string('city')->default('')->comment('城市');
            $table->string('avatar')->default('')->comment('头像');
            $table->unsignedTinyInteger('gender')->default(0)->comment('1男2女0未知');
            $table->unsignedInteger('client_id')->default(0)->comment('所属客户端 ID');
            //$table->timestamp('subscribe_at')->comment('关注公众号时间');
            $table->timestamp('last_login_time')->comment('最后登录时间');
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
        Schema::dropIfExists('users');
    }
}
