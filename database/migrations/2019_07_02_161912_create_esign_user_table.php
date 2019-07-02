<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsignUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esign_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('accountid')->default('')->comment('E签宝用户ID');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            //$table->timestamps();

            $table->index('accountid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esign_user');
    }
}
