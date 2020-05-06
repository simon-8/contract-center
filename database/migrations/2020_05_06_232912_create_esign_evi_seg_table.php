<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsignEviSegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 证据点表, 每个场景多个证据点, 可能重名
        Schema::create('esign_evi_seg', function (Blueprint $table) {
            $table->string('name')->default('')->comment('证据点名称');
            $table->string('id')->default('')->comment('证据点ID');
            $table->string('scene_id')->default('')->comment('场景ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esign_evi_seg');
    }
}
