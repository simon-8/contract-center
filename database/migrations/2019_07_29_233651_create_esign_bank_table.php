<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsignBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esign_bank', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank_code')->default('')->comment('银行代号');
            $table->string('bank_name')->default('')->comment('银行名称');
            $table->string('sub_name')->default('')->comment('支行名称');
            $table->string('province')->default('')->comment('省份');
            $table->string('city')->default('')->comment('城市');
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
        Schema::dropIfExists('esign_bank');
    }
}
