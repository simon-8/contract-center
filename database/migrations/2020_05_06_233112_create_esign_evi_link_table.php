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
            $table->string('scene_id')->default('')->comment('场景名称ID');
            $table->string('scene_evid')->default('')->comment('场景式存证编号');
            $table->string('seg_id')->default('')->comment('证据点名称ID');
            $table->text('point_url')->comment('证据点文档保全上传 URL');
            $table->string('point_evid')->default('')->comment('证据点存证编号');
            $table->unsignedTinyInteger('status')->default(0)->comment('证据链状态(自用)');
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
