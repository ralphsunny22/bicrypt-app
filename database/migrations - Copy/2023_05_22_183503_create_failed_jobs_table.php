<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('connection')->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->text('queue')->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->longText('payload')->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->longText('exception')->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->timestamp('failed_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}
