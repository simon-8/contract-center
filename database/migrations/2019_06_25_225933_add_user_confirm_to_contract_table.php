<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserConfirmToContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract', function (Blueprint $table) {
            $table->unsignedTinyInteger('targetid')->default(0)->comment('对方id')->after('userid');
            $table->unsignedTinyInteger('user_confirm')->default(0)->comment('用户确认')->after('jujianren');
            $table->unsignedTinyInteger('target_confirm')->default(0)->comment('对方确认')->after('user_confirm');
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
            //
        });
    }
}
