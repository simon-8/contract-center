<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsignEviSceneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 场景表 每个行业多个场景, 可能重名
        Schema::create('esign_evi_scene', function (Blueprint $table) {
            $table->string('name')->default('')->comment('场景名称');
            $table->string('id')->default('')->comment('场景ID');
            $table->string('business_id')->default('')->comment('行业ID');
            $table->unsignedInteger('catid')->default(0)->comment('关联分类ID');
            $table->string('seg_id')->default('')->comment('证据点名称ID');
            $table->unsignedTinyInteger('seg_has_attr')->default(0)->comment('证据点字段属性是否已建立');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esign_evi_scene');
    }
}
