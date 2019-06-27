<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            $table->string('linkman')->default('')->comment('联系人');
            $table->string('mobile')->default('')->comment('联系电话');
            $table->string('country')->default('')->comment('国家');
            $table->string('province')->default('')->comment('省');
            $table->string('city')->default('')->comment('城市');
            $table->string('address')->default('')->comment('地址');
            $table->char('postcode', 5)->default('')->comment('邮编');
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
        Schema::dropIfExists('user_address');
    }
}
