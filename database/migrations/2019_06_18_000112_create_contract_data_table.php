<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('userid')->default(0)->comment('用户ID');
            $table->unsignedInteger('contract_id')->default(0)->comment('合同ID');
            $table->unsignedInteger('folder_id')->default(0)->comment('合同ID');
            $table->string('name')->default('')->comment('材料名称');
            $table->string('linkurl')->default('')->comment('材料链接');
            $table->string('filetype')->default('')->comment('文件类型');
            $table->unsignedDecimal('filesize')->default(0)->comment('文件大小');

            $table->timestamps();

            $table->index([
                'userid',
                'contract_id',
                'folder_id',
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
        Schema::dropIfExists('contract_data');
    }
}
