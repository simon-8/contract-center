<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTplSecondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_tpl_second', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('catid')->default(0)->comment('分类ID');
            $table->string('content')->default('')->comment('内容');
            $table->unsignedTinyInteger('listorder')->default(0)->comment('排序');
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
        Schema::dropIfExists('contract_tpl_second');
    }
}
