<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('method_code');
            $table->decimal('amount', 18, 8);
            $table->string('method_currency', 191)->collation('utf8mb4_unicode_ci');
            $table->decimal('charge', 18, 8);
            $table->decimal('rate', 18, 8);
            $table->decimal('final_amo', 18, 8)->default('0.00000000');
            $table->text('detail')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('btc_amo', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('btc_wallet', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('trx', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('try')->default(0);
            $table->tinyInteger('status')->default(0)->comment('1=>success, 2=>pending, 3=>cancel');
            $table->string('admin_feedback', 250)->collation('utf8mb4_unicode_ci')->nullable();
            $table->timestamps();
            $table->string('symbol', 34)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('address', 34)->collation('utf8mb4_unicode_ci')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
