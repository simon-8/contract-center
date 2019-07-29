<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsignBankAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esign_bank_area', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->timestamps();
            $table->string('province')->default('')->comment('省份');
            $table->string('city')->default('')->comment('城市');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esign_bank_area');
    }
}
