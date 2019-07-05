<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsignSignLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esign_sign_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('contract_id')->default(0)->comment('合同ID');
            $table->string('name')->default('')->comment('文档名称');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            $table->string('serviceid')->default('')->comment('签署记录ID');

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
        Schema::dropIfExists('esign_sign_logs');
    }
}
