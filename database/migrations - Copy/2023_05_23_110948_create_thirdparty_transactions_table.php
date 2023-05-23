<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdpartyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thirdparty_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('symbol', 255)->nullable();
            $table->string('chain', 32)->nullable();
            $table->string('memo', 32)->nullable();
            $table->string('sending_address', 255)->nullable();
            $table->string('recieving_address', 255)->nullable();
            $table->decimal('amount', 18, 8)->nullable();
            $table->decimal('fee', 18, 8)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('trx_id', 255)->nullable();
            $table->tinyInteger('type')->nullable()->comment('1 = deposit, 2 = withdraw, 3 = send, 4 = request');
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('thirdparty_transactions');
    }
}
