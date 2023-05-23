<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('support_message_id');
            $table->string('attachment', 255);
            $table->timestamps();

            $table->foreign('support_message_id')
                ->references('id')
                ->on('support_messages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_attachments');
    }
}
