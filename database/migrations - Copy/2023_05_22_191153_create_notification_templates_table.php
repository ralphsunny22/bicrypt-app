<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('act', 40)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('name', 40)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('subj', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('email_body')->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('sms_body')->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('push_notification_body')->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('shortcodes')->nullable()->collation('utf8mb4_unicode_ci');
            $table->tinyInteger('email_status')->unsigned()->default(1);
            $table->tinyInteger('sms_status')->unsigned()->default(1);
            $table->tinyInteger('push_notification_status')->unsigned()->default(1);
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
        Schema::dropIfExists('notification_templates');
    }
}
