<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('pid')->default(0)->comment('父类ID');
            $table->string('name')->default('')->comment('分类名称');
            $table->unsignedTinyInteger('players')->default(0)->comment('参与人类型');
            $table->string('user_type')->default('')->comment('用户类型');
            $table->unsignedInteger('company_id')->default(0)->comment('公司ID');
            $table->string('introduce')->default('')->comment('简介');
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
        Schema::dropIfExists('contract_category');
    }
}
