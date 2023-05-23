<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdpartyProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thirdparty_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('api', 255)->nullable();
            $table->string('secret', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('installed')->nullable();
            $table->tinyInteger('activated')->nullable();
            $table->string('current_version', 255)->default('0.0.1');
            $table->string('product_id', 255)->nullable();
            $table->tinyInteger('development')->default(1);
            $table->text('url')->nullable();
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
        Schema::dropIfExists('thirdparty_providers');
    }
}
