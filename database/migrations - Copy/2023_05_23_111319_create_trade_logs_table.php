<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('symbol', 255)->collation('utf8mb4_unicode_ci');
            $table->string('pair', 255)->collation('utf8mb4_unicode_ci')->default('USDT');
            $table->decimal('amount', 18, 8)->default(0.00000000);
            $table->decimal('margin', 18, 8);
            $table->decimal('price_was', 18, 8)->default(0.00000000);
            $table->integer('duration');
            $table->timestamp('in_time')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyText('tradetype')->collation('utf8mb4_unicode_ci');
            $table->tinyInteger('hilow')->default(0)->comment('Rise : 1 Fall: 2');
            $table->tinyInteger('result')->default(0)->comment('win : 1 lose : 2 Draw : 3');
            $table->tinyInteger('status')->default(0)->comment('Running : 0 Complete : 1');
            $table->timestamps();
            
            $table->unique('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_logs');
    }
}
