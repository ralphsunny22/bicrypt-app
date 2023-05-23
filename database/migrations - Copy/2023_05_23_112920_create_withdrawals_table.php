<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('method_id');
            $table->unsignedInteger('user_id');
            $table->decimal('amount', 18, 8);
            $table->string('currency', 40)->collation('utf8mb4_unicode_ci');
            $table->decimal('rate', 18, 8);
            $table->decimal('charge', 18, 8);
            $table->string('trx', 40)->collation('utf8mb4_unicode_ci');
            $table->decimal('final_amount', 18, 8)->default(0.00000000);
            $table->decimal('after_charge', 18, 8);
            $table->text('withdraw_information')->collation('utf8mb4_unicode_ci')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1=>success, 2=>pending, 3=>cancel');
            $table->text('admin_feedback')->collation('utf8mb4_unicode_ci')->nullable();
            $table->timestamps();
            $table->string('address', 34)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('symbol', 34)->collation('utf8mb4_unicode_ci')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
}
