<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduledOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('market', 255);
            $table->string('pair', 255);
            $table->decimal('price', 18, 8);
            $table->decimal('margin', 18, 8);
            $table->decimal('amount', 18, 8);
            $table->integer('duration');
            $table->timestamp('in_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('account')->comment('Practice: 1 Trade: 2');
            $table->tinyInteger('type')->comment('Rise: 1 Fall: 2');
            $table->tinyInteger('method')->comment('Higher: 1 Lower: 2');
            $table->tinyInteger('status')->comment('Placed: 0 Pending: 1');
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
        Schema::dropIfExists('scheduled_orders');
    }
}
