<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('from_userid')->default(0)->comment('发送人id');
            $table->unsignedInteger('to_userid')->default(0)->comment('接收人id');
            $table->string('title')->default('')->comment('站内信标题');
            $table->text('content')->comment('内容');
            $table->unsignedTinyInteger('is_read')->default(0)->comment('是否已读');
            $table->timestamps();

            $table->index('from_userid');
            $table->index('to_userid');
            $table->index('is_read');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message');
    }
}
