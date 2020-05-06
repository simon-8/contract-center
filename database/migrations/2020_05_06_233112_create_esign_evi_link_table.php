<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsignEviLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 证据链表
        Schema::create('esign_evi_link', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_id')->default(0)->comment('关联合同ID');
            $table->string('scene_name')->default('')->comment('场景名称');
            $table->string('scene_id')->default('')->comment('场景ID');
            $table->string('evid')->default('')->comment('场景名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esign_evi_link');
    }
}
