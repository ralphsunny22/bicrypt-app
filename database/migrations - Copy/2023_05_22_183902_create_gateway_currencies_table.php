<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatewayCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway_currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('currency', 191)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('symbol', 191)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->integer('method_code')->nullable(true);
            $table->string('gateway_alias', 25)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->decimal('min_amount', 18, 8)->nullable(false);
            $table->decimal('max_amount', 18, 8)->nullable(false);
            $table->decimal('percent_charge', 5, 2)->nullable(false)->default(0.00);
            $table->decimal('fixed_charge', 18, 8)->nullable(false)->default(0.00000000);
            $table->decimal('rate', 18, 8)->nullable(false)->default(0.00000000);
            $table->string('image', 191)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->text('gateway_parameter')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->timestamp('created_at')->nullable(true);
            $table->timestamp('updated_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gateway_currencies');
    }
}
