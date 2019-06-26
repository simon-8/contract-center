<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRefundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_refund', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pid')->default(0)->comment('对应订单ID');
            $table->string('refund_orderid')->default('')->comment('退款订单号');
            $table->string('refund_torderid')->default('')->comment('退款系统订单号');
            $table->string('pay_orderid')->default('')->comment('对应付款订单号');
            $table->unsignedDecimal('amount', 10, 2)->default(0)->comment('退款金额');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            $table->unsignedInteger('adminid')->default(0)->comment('管理员ID');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 0待退款 1已退款 2退款失败');
            $table->string('remark')->default('')->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_refund');
    }
}
