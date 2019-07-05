<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('合同名称');
            $table->unsignedInteger('catid')->default(0)->comment('合同分类');
            $table->unsignedInteger('userid')->default(0)->comment('关联用户ID');
            $table->unsignedInteger('lawyerid')->default(0)->comment('关联律师ID');
            $table->unsignedTinyInteger('mycatid')->default(0)->comment('我的分类(文件夹)');
            $table->string('jiafang')->default('')->comment('甲方');
            $table->string('yifang')->default('')->comment('乙方');
            $table->string('jujianren')->default('')->comment('居间人');

            $table->unsignedInteger('userid_first')->default(0)->comment('甲方用户ID');
            $table->unsignedInteger('userid_second')->default(0)->comment('乙方用户ID');
            $table->unsignedInteger('userid_three')->default(0)->comment('居间人用户ID');

            $table->unsignedTinyInteger('confirm_first')->default(0)->comment('甲方是否已确认');
            $table->unsignedTinyInteger('confirm_second')->default(0)->comment('乙方是否已确认');
            $table->unsignedTinyInteger('confirm_three')->default(0)->comment('居间人是否已确认');

            $table->unsignedTinyInteger('signed_first')->default(0)->comment('甲方是否已签名');
            $table->unsignedTinyInteger('signed_second')->default(0)->comment('乙方是否已签名');
            $table->unsignedTinyInteger('signed_three')->default(0)->comment('居间人是否已签名');

            $table->unsignedTinyInteger('status')->default(0)->comment('状态');
            $table->timestamp('confirm_at')->comment('确认时间');
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
        Schema::dropIfExists('contract');
    }
}
