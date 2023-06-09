<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 10)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('code', 50)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('symbol', 5)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('rate', 50)->collation('utf8mb4_unicode_ci')->default('1');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('currencies');
    }
}
