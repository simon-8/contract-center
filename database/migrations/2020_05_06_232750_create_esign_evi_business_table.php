<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsignEviBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 行业表
        Schema::create('esign_evi_business', function (Blueprint $table) {
            $table->string('name')->default('')->comment('行业名称')->unique();
            $table->string('id')->comment('行业ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esign_evi_business');
    }
}
