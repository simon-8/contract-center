<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVtruenameFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('vtruename')->default(0)->comment('是否实名认证')->after('is_block');
            $table->unsignedTinyInteger('vcompany')->default(0)->comment('是否公司认证')->after('vtruename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('vtruename');
            $table->dropColumn('vcompany');
        });
    }
}
