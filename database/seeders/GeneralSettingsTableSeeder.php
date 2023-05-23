<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert([
            'id' => 1,
            'sitename' => 'Bicrypto',
            'cur_text' => 'USD',
            'cur_sym' => '$',
            'profit' => 87.00000000,
            'practice_balance' => 10000.00000000,
            'force_ssl' => 0,
            'registration' => 1,
            'last_cron_run' => '2022-11-21 20:29:06',
            'exchange_fee' => '3',
            'practice_wallet' => 'USDT',
            'trx_fee' => '3',
            'limits' => '{"min_amount":"0.000001","max_amount":"10000","min_time_sec":"10","max_time_sec":"10000","min_time_min":"1","max_time_min":"10000","min_time_hour":"1","max_time_hour":"10000"}',
            'provider_withdraw_fee' => 3.00,
            'staging' => 0,
            'cors' => '',
            'new_version' => '1.6.1.3',
            'frontend' => '/builder/themes/landing/index.html',
            'created_at' => '2022-08-24 06:20:01',
            'updated_at' => '2022-11-23 21:29:27',
            'tinymce' => '',
        ]);
    }
}
