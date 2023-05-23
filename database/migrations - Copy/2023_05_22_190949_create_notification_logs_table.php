<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->default(0);
            $table->string('sender', 40)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('sent_from', 40)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('sent_to', 40)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('subject', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('message')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('notification_type', 40)->nullable()->collation('utf8mb4_unicode_ci');
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
        Schema::dropIfExists('notification_logs');
    }
}
