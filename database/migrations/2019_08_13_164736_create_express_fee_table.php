<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('express_fee', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            //$table->unsignedInteger('pid')->default(0)->comment('父ID');
            $table->string('name')->default('')->comment('地区名称');
            $table->unsignedInteger('amount')->default(0)->comment('费用');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('express_fee');
    }
}
