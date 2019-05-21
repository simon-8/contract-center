<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOauthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_oauth', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userid')->default(0);
            $table->string('openid')->default('')->comment('OPENID');
            $table->string('unionid')->default('')->comment('UNIONID');
            $table->string('channel')->default('')->comment('渠道');
            $table->unsignedSmallInteger('client_id')->default(0)->comment('客户端ID');
            $table->timestamps();

            // 索引
            $table->index('userid');
            $table->index('openid');
            $table->index('unionid');
            $table->index('channel');
            $table->index('client_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_oauth');
    }
}
