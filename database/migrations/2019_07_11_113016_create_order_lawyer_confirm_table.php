<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLawyerConfirmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lawyer_confirm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('contract_id')->default(0)->comment('合同ID');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            $table->unsignedDecimal('amount', 10, 2)->default(0)->comment('金额');
            $table->string('orderid')->default('')->comment('订单ID');
            $table->string('torderid')->default('')->comment('第三方订单ID');
            $table->string('channel')->default('')->comment('支付渠道');
            $table->string('gateway')->default('')->comment('支付方式');
            $table->string('openid')->default('')->comment('openid');
            $table->string('remark')->default('')->comment('备注');
            $table->json('address')->comment('地址json');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 0待支付 1已支付');
            $table->unsignedSmallInteger('client_id')->default(0)->comment('客户端ID');
            $table->timestamp('payed_at')->nullable()->comment('付款时间');
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
        Schema::dropIfExists('order_lawyer_confirm');
    }
}
