<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotifyToOauthClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->string('notify')->nullable()->comment('通知 URL'); //手机
            //$table->bigInteger('coin')->unsigned()->default(0)->comment('可兑换金币'); //手机
            //$table->tinyInteger('sync_login')->unsigned()->default(0)->comment('是否同步登陆'); //手机
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropColumn('notify');
            $table->dropColumn('coin');
            $table->dropColumn('sync_login');
        });
    }
}
