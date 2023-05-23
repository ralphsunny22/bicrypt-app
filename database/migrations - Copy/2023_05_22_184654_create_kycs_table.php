<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKycsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kycs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userId');
            $table->string('firstName', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('lastName', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('email', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('phone', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('dob', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('gender', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('address1', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('address2', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('city', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('state', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('zip', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('country', 255)->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->string('telegram', 255)->collation('utf8mb4_unicode_ci')->default('');
            $table->string('documentType', 255)->collation('utf8mb4_unicode_ci')->default('');
            $table->string('document', 255)->collation('utf8mb4_unicode_ci')->default('');
            $table->string('document2', 255)->collation('utf8mb4_unicode_ci')->default('');
            $table->string('document3', 255)->collation('utf8mb4_unicode_ci')->default('');
            $table->text('notes')->collation('utf8mb4_unicode_ci')->nullable(true);
            $table->unsignedInteger('reviewedBy')->default(0);
            $table->dateTime('reviewedAt')->nullable(true);
            $table->string('status', 255)->collation('utf8mb4_unicode_ci')->default('pending');
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
        Schema::dropIfExists('kycs');
    }
}
