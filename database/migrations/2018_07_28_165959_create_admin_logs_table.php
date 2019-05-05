<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userid')->comment('管理员ID');
            $table->string('event')->default('')->comment('事件');
            $table->string('data')->default('')->comment('数据');
            $table->string('ip')->default('')->comment('IP');
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
        Schema::dropIfExists('admin_logs');
    }
}
