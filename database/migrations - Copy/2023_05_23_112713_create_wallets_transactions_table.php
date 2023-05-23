<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('symbol', 34)->nullable();
            $table->decimal('amount', 18, 8)->default(0.00000000);
            $table->decimal('amount_recieved', 18, 8)->default(0.00000000);
            $table->decimal('charge', 18, 8)->default(0.00000000);
            $table->decimal('fees', 18, 8)->default(0.00000000);
            $table->string('to', 34)->nullable();
            $table->string('type', 10)->nullable()->comment('1 = deposit, 2 = withdraw, 3 = transfer');
            $table->string('chain', 32)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('trx', 255)->nullable();
            $table->string('wallet_type', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('details', 255)->nullable();
            $table->timestamps();
            $table->unique('trx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets_transactions');
    }
}
