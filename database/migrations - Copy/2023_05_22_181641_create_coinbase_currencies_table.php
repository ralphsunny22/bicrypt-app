<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinbaseCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coinbase_currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('symbol', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('type', 255)->nullable();
            $table->integer('network_confirmations')->nullable();
            $table->integer('sort_order')->nullable();
            $table->text('crypto_address_link')->nullable();
            $table->text('crypto_transaction_link')->nullable();
            $table->decimal('min_withdrawal_amount', 18, 8)->nullable();
            $table->decimal('max_withdrawal_amount', 18, 8)->nullable();
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
        Schema::dropIfExists('coinbase_currencies');
    }
}
