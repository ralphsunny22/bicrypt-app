<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontends', function (Blueprint $table) {
            $table->increments('id');
            $table->string('data_keys', 40)->collation('utf8mb4_unicode_ci')->nullable(false)->unique();
            $table->longText('data_values')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->timestamp('updated_at')->nullable(true);
            $table->timestamp('created_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frontends');
    }
}
