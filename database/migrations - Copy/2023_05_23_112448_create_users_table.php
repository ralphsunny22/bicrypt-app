<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->string('firstname', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('email', 90);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username', 50);
            $table->string('password', 255);
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->unsignedBigInteger('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->integer('ref_by')->nullable();
            $table->decimal('balance', 18, 8)->default(0.00000000);
            $table->decimal('balance_btc', 18, 8)->default(0.00000000);
            $table->decimal('practice_balance', 18, 8)->default(0.00000000);
            $table->decimal('practice_balance_btc', 18, 8)->default(0.00000000);
            $table->text('country')->nullable();
            $table->text('country_code')->nullable();
            $table->text('zip')->nullable();
            $table->text('address')->nullable();
            $table->text('city')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0: banned, 1: active');
            $table->tinyInteger('kyc')->default(0)->comment('0: kyc unverified, 1: kyc verified');
            $table->unsignedBigInteger('role_id')->default(2);
            $table->text('twitter')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('linkedin')->nullable();
            $table->string('timezone', 255)->nullable();
            $table->string('registerMethod', 191)->default('Email');
            $table->string('dob', 255)->nullable();
            $table->timestamps();
            $table->string('eth_Address', 255)->nullable();
            $table->tinyInteger('active_status')->default(0);
            $table->tinyInteger('dark_mode')->default(0);
            $table->string('messenger_color', 255)->default('#2180f3');
            $table->text('phone')->nullable();
            $table->text('state')->nullable();
            $table->text('fcm_token')->nullable();
            $table->unique(['username', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
