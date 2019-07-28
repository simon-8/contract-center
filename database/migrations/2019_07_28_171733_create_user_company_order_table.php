<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCompanyOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_company_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('pid')->comment('父ID');
            $table->unsignedDecimal('amount')->default(0)->comment('价格');
            $table->string('orderid')->default('')->comment('订单ID');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            $table->string('remark')->default('')->comment('备注');
            $table->timestamps();

            $table->index('userid');
            $table->index('orderid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_company_order');
    }
}
