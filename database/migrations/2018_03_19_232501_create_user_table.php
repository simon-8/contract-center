<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->comment('openid')->default('');
            $table->string('truename')->comment('姓名')->default('');
            $table->string('mobile')->comment('手机号')->default('');
            $table->string('nickname')->comment('昵称')->default('');
            $table->string('avatar')->comment('头像')->default('');
            $table->string('language')->comment('语言')->default('');
            $table->string('city')->comment('城市')->default('');
            $table->string('province')->comment('省')->default('');
            $table->string('country')->comment('国家')->default('');
            $table->string('unionid')->comment('unionid')->default('');
            $table->timestamp('subscribed_at')->comment('关注时间')->nullable();
            $table->timestamps();

            // 索引
            $table->unique('openid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
