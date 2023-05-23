<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateways', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->nullable(true);
            $table->string('alias', 191)->collation('utf8mb4_unicode_ci')->default('NULL');
            $table->string('image', 191)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('name', 191)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->tinyInteger('status')->nullable(false)->default(1);
            $table->text('parameters')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->text('supported_currencies')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->tinyInteger('crypto')->nullable(false)->default(0)->comment('0: fiat currency, 1: crypto currency');
            $table->text('extra')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->text('description')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->text('input_form')->collation('utf8mb4_unicode_ci')->nullable(true);
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
        Schema::dropIfExists('gateways');
    }
}
