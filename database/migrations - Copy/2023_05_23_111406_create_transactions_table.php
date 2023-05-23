<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('currency', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->decimal('amount', 18, 8)->default(0.00000000);
            $table->decimal('charge', 18, 8)->default(0.00000000);
            $table->decimal('post_balance', 18, 8)->default(0.00000000);
            $table->string('trx_type', 10)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('trx', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('details', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
            $table->string('txHash', 100)->collation('utf8mb4_unicode_ci')->nullable();
            
            $table->index(['user_id', 'currency']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
