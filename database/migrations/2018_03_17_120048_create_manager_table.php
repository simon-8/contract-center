<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',50)->comment('用户名');
            $table->string('password',255)->comment('密码');
            //$table->unsignedTinyInteger('groupid')->comment('会员组ID');
            $table->string('truename',50)->comment('真实姓名')->default('');
            $table->string('email',100)->comment('邮箱号码')->default('');
            $table->unsignedTinyInteger('is_admin')->comment('是否管理员')->default(0);
            $table->string('role')->comment('权限列表')->default('');
            $table->string('avatar')->comment('头像')->default('');
            //$table->string('salt',4)->comment('密码加盐');
            $table->string('lastip')->comment('上一次登录ip')->default('');
            $table->timestamp('lasttime')->comment('最后登录时间');
            $table->rememberToken();//记住我
            $table->timestamps();//时间戳

            // 索引
            $table->unique('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manager');
    }
}
