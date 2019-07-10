<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSignTypeFirstToContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract', function (Blueprint $table) {

            $table->unsignedTinyInteger('sign_type_first')->default(0)->comment('甲方签名类型 0个人 1公司')->after('signed_three');
            $table->unsignedTinyInteger('sign_type_second')->default(0)->comment('乙方签名类型 0个人 1公司')->after('sign_type_first');
            $table->unsignedTinyInteger('sign_type_three')->default(0)->comment('居间人签名类型 0个人 1公司')->after('sign_type_second');
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
            $table->dropColumn('sign_type_first');
            $table->dropColumn('sign_type_second');
            $table->dropColumn('sign_type_three');
        });
    }
}
