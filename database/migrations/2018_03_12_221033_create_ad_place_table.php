<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdPlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_place', function (Blueprint $table) {
            $table->increments('id');
            //$table->unsignedInteger('aid')->comment('活动ID')->default(0);
            $table->string('name')->comment('广告位名称')->default('');
            $table->unsignedSmallInteger('width')->comment('广告位宽度')->default(0);
            $table->unsignedSmallInteger('height')->comment('广告位高度')->default(0);
            $table->unsignedTinyInteger('status')->comment('广告位状态')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_place');
    }
}
