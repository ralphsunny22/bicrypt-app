<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extensions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->text('description')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('image', 191)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('slug', 191)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('installed')->nullable(false);
            $table->tinyInteger('activated')->nullable(false);
            $table->string('product_id', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('current_version', 255)->collation('utf8mb4_unicode_ci')->default('0.0.1');
            $table->timestamps();
            $table->tinyInteger('dev')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extensions');
    }
}
