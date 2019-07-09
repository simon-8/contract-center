<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            $table->string('name')->default('')->comment('组织名称');
            $table->string('organ_code')->default('')->comment('机构代码');
            $table->unsignedTinyInteger('reg_type')->default(0)->comment('机构类型');
            $table->text('sign_data')->default('')->comment('签名图片base64数据')->nullable();
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
        Schema::dropIfExists('user_company');
    }
}
