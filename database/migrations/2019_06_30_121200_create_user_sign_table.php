<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sign', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('contract_id')->default(0)->comment('合同ID');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            $table->string('thumb')->default('')->comment('图片地址');
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
        Schema::dropIfExists('user_sign');
    }
}
