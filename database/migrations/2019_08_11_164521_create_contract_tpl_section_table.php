<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTplSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_tpl_section', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('catid')->default(0)->comment('所属分类');
            $table->unsignedInteger('players')->default(0)->comment('几方合同 两方 三方');
            $table->string('name')->default('')->comment('模板段名称');
            $table->unsignedInteger('listorder')->default(0)->comment('排序');
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
        Schema::dropIfExists('contract_tpl_section');
    }
}
