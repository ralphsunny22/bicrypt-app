<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('symbol');
            $table->string('pair')->default('USDT');
            $table->decimal('amount', 18, 8)->default(0.00000000);
            $table->decimal('margin', 18, 8);
            $table->decimal('price_was', 18, 8)->default(0.00000000);
            $table->integer('duration');
            $table->timestamp('in_time')->useCurrent();
            $table->tinyInteger('hilow')->default(0)->comment('Rise : 1 Fall : 2');
            $table->tinyInteger('result')->default(0)->comment('win : 1 lose : 2 Draw : 3');
            $table->tinyInteger('status')->default(0)->comment('Running : 0 Complete : 1');
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
        Schema::dropIfExists('practice_logs');
    }
}
