<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractSignCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_sign_code', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_id')->default(0)->comment('父ID');
            $table->unsignedBigInteger('userid_first')->default(0)->comment('用户ID');
            $table->unsignedBigInteger('userid_second')->default(0)->comment('用户ID');
            $table->unsignedBigInteger('userid_three')->default(0)->comment('用户ID');
            $table->string('mobile_first')->default('')->comment('手机号码');
            $table->string('mobile_second')->default('')->comment('手机号码');
            $table->string('mobile_three')->default('')->comment('手机号码');
            $table->string('code_first')->default('')->comment('验证码');
            $table->string('code_second')->default('')->comment('验证码');
            $table->string('code_three')->default('')->comment('验证码');
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
        Schema::dropIfExists('contract_sign_code');
    }
}
