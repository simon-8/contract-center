<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTplTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_tpl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('section_id')->default(0)->comment('所属区块');
            $table->text('content')->comment('内容');
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
        Schema::dropIfExists('contract_tpl');
    }
}
