<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_folder', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('文件夹名');
            $table->string('thumb')->default('')->comment('缩略图');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            $table->unsignedInteger('contract_id')->default(0)->comment('合同ID');
            $table->timestamps();

            $table->index([
                'userid',
                'contract_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_folder');
    }
}
