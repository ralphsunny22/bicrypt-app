<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sitename', 50)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('cur_text', 20)->collation('utf8mb4_unicode_ci')->nullable(true)->comment('currency text');
            $table->string('cur_sym', 20)->collation('utf8mb4_unicode_ci')->nullable(true)->comment('currency symbol');
            $table->decimal('profit', 18, 8)->default(0.00000000);
            $table->decimal('practice_balance', 18, 8)->default(0.00000000);
            $table->tinyInteger('force_ssl')->nullable(false)->default(0);
            $table->tinyInteger('registration')->nullable(false)->default(0)->comment('0: Off, 1: On');
            $table->timestamp('last_cron_run')->nullable(true);
            $table->string('exchange_fee', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('practice_wallet', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('trx_fee', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->text('limits')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->decimal('provider_withdraw_fee', 10, 2)->nullable(true);
            $table->tinyInteger('staging')->nullable(true);
            $table->text('cors')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->text('new_version')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->text('frontend')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->timestamp('created_at')->nullable(true);
            $table->timestamp('updated_at')->nullable(true);
            $table->text('tinymce')->collation('utf8mb4_unicode_ci')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
}
