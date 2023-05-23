<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GatewaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gateways')->insert([
            [
                'id' => 2,
                'code' => 102,
                'alias' => 'perfect_money',
                'image' => '61c665efc38b81640392175.png',
                'name' => 'Perfect Money',
                'status' => 1,
                'parameters' => '{"passphrase":{"title":"ALTERNATE PASSPHRASE","global":true,"value":""},"wallet_id":{"title":"PM Wallet","global":false,"value":""}}',
                'supported_currencies' => '{"USD":"$","EUR":"\u20ac"}',
                'crypto' => 0,
                'extra' => null,
                'description' => null,
                'input_form' => null,
                'created_at' => '2019-09-14 16:14:22',
                'updated_at' => '2022-01-26 17:02:27',
            ],
            [
                'id' => 3,
                'code' => 103,
                'alias' => 'stripe',
                'image' => '61c6659301aec1640392083.png',
                'name' => 'Stripe Hosted',
                'status' => 1,
                'parameters' => '{"secret_key":{"title":"Secret Key","global":true,"value":""},"publishable_key":{"title":"PUBLISHABLE KEY","global":true,"value":""}}',
                'supported_currencies' => '{"USD":"USD","AUD":"AUD","BRL":"BRL","CAD":"CAD","CHF":"CHF","DKK":"DKK","EUR":"EUR","GBP":"GBP","HKD":"HKD","INR":"INR","JPY":"JPY","MXN":"MXN","MYR":"MYR","NOK":"NOK","NZD":"NZD","PLN":"PLN","SEK":"SEK","SGD":"SGD"}',
                'crypto' => 0,
                'extra' => null,
                'description' => null,
                'input_form' => null,
                'created_at' => '2019-09-14 16:14:22',
                'updated_at' => '2022-04-03 18:40:58',
            ],
            // Add the remaining records in the same format
            // ...
        ]);
    }
}
