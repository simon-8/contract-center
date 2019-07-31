<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdToContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract', function (Blueprint $table) {
            $table->unsignedInteger('companyid_first')->default(0)->comment('甲方公司ID')->after('userid_three');
            $table->unsignedInteger('companyid_second')->default(0)->comment('乙方公司ID')->after('companyid_first');
            $table->unsignedInteger('companyid_three')->default(0)->comment('丙方公司ID')->after('companyid_second');
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
            $table->dropColumn('companyid_first');
            $table->dropColumn('companyid_second');
            $table->dropColumn('companyid_three');
        });
    }
}
