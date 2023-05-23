<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('settings')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('site_name', 40)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('public_key', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('private_key', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('merchant_id', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('email_from', 40)->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('email_template')->nullable()->collation('utf8mb4_unicode_ci');
            $table->tinyInteger('sms_status')->nullable();
            $table->string('sms_body', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('sms_from', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('mail_config')->nullable()->comment('email configuration')->collation('utf8mb4_unicode_ci');
            $table->text('sms_config')->nullable()->collation('utf8mb4_unicode_ci');
            $table->tinyInteger('push_status')->nullable();
            $table->text('push_notification_config')->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('global_shortcodes')->nullable()->collation('utf8mb4_unicode_ci');
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
        Schema::dropIfExists('notification_settings');
    }
}
