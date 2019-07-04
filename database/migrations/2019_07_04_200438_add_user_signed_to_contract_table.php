<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserSignedToContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract', function (Blueprint $table) {
            $table->unsignedTinyInteger('user_signed')->default(0)->comment('用户已签名')->after('target_confirm');
            $table->unsignedTinyInteger('target_signed')->default(0)->comment('对方已签名')->after('user_signed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract', function (Blueprint $table) {
            $table->dropColumn('user_signed');
            $table->dropColumn('target_signed');
        });
    }
}
