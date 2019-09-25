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
            $table->string('legal_name')->default('')->comment('法人身份证姓名');
            $table->string('legal_idno')->default('')->comment('法人身份证号码');
            $table->string('mobile', 50)->default('')->comment('联系手机');
            $table->string('address')->default('')->comment('注册地址');
            $table->string('seal_img')->default('')->comment('印章图片地址');
            $table->text('sign_data')->nullable()->comment('签名图片base64数据');
            $table->string('service_id')->default('')->comment('服务ID');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
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
