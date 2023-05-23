<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdpartyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thirdparty_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('order_id', 255)->nullable();
            $table->string('symbol', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('side', 255)->nullable();
            $table->decimal('price', 18, 8)->nullable();
            $table->decimal('stopPrice', 18, 8)->nullable();
            $table->decimal('amount', 18, 8)->nullable();
            $table->decimal('cost', 18, 8)->nullable();
            $table->decimal('average', 18, 8)->nullable();
            $table->decimal('filled', 18, 8)->nullable();
            $table->decimal('remaining', 18, 8)->nullable();
            $table->string('status', 255)->nullable();
            $table->decimal('fee', 18, 8)->nullable();
            $table->string('provider', 255)->nullable();
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
        Schema::dropIfExists('thirdparty_orders');
    }
}
