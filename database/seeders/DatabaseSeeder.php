<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        
        // DB::table('migrations')->insert([
        //     [
        //         'id' => 295,
        //         'migration' => '2019_12_14_000001_create_personal_access_tokens_table',
        //         'batch' => 1,
        //     ],
        // ]);

        DB::table('coinbase_currencies')->insert([
            [
                'id' => 174,
                'symbol' => 'DASH',
                'name' => 'Dash',
                'status' => 1,
                'type' => 'crypto',
                'network_confirmations' => 2,
                'sort_order' => 47,
                'crypto_address_link' => 'https://chain.so/address/DASH/{{address}}',
                'crypto_transaction_link' => 'https://chain.so/tx/DASH/{{address}}',
                'min_withdrawal_amount' => 0.00010000,
                'max_withdrawal_amount' => 5900.00000000,
                'created_at' => '2022-03-29 10:28:30',
                'updated_at' => '2022-09-25 06:40:00',
            ],
            [
                'id' => 175,
                'symbol' => 'CVC',
                'name' => 'Civic',
                'status' => 1,
                'type' => 'crypto',
                'network_confirmations' => 14,
                'sort_order' => 125,
                'crypto_address_link' => 'https://etherscan.io/token/0x41e5560054824ea6b0732e656e3ad64e20e94e45?a={{address}}',
                'crypto_transaction_link' => 'https://etherscan.io/tx/0x{{txId}}',
                'min_withdrawal_amount' => 0.01000000,
                'max_withdrawal_amount' => 9987700.00000000,
                'created_at' => '2022-03-29 10:28:30',
                'updated_at' => '2022-09-25 06:40:00',
            ],
            [
                'id' => 176,
                'symbol' => 'STORJ',
                'name' => 'Storj',
                'status' => 1,
                'type' => 'crypto',
                'network_confirmations' => 14,
                'sort_order' => 440,
                'crypto_address_link' => 'https://etherscan.io/token/0xb64ef51c888972c908cfacf59b47c1afbc0ab8ac?a={{address}}',
                'crypto_transaction_link' => 'https://etherscan.io/tx/0x{{txId}}',
                'min_withdrawal_amount' => 0.01000000,
                'max_withdrawal_amount' => 1825300.00000000,
                'created_at' => '2022-03-29 10:28:30',
                'updated_at' => '2022-09-25 06:40:00',
            ],
        ]);

        DB::table('currencies')->insert([
            [
                'id' => 1,
                'name' => 'Leke',
                'code' => 'ALL',
                'symbol' => 'Lek',
                'rate' => '110.149881',
                'status' => 0,
                'created_at' => null,
                'updated_at' => '2022-04-07 04:48:08',
            ],
            [
                'id' => 2,
                'name' => 'US Dollars',
                'code' => 'USD',
                'symbol' => '$',
                'rate' => '1',
                'status' => 1,
                'created_at' => null,
                'updated_at' => '2022-10-22 01:22:10',
            ],
            [
                'id' => 3,
                'name' => 'Afghanis',
                'code' => 'AFN',
                'symbol' => '؋',
                'rate' => '73.097502',
                'status' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        DB::table('extensions')->insert([
            [
                'id' => 1,
                'name' => 'Bot Trader',
                'description' => 'Bot Trader Extension',
                'image' => 'botTrader.png',
                'slug' => 'botTrader',
                'status' => 0,
                'installed' => 0,
                'activated' => 0,
                'product_id' => 'B96677A0',
                'current_version' => '0.0.1',
                'created_at' => '2022-01-31 18:36:32',
                'updated_at' => '2022-11-02 21:05:37',
                'dev' => 0,
            ],
            [
                'id' => 2,
                'name' => 'Token ICO',
                'description' => 'Token ICO Extension',
                'image' => 'tokenICO.png',
                'slug' => 'ico',
                'status' => 0,
                'installed' => 0,
                'activated' => 0,
                'product_id' => '61433370',
                'current_version' => '0.0.1',
                'created_at' => '2022-01-31 18:36:32',
                'updated_at' => '2022-11-02 21:06:01',
                'dev' => 0,
            ],
            // Add more entries here if needed
            [
                'id' => 12,
                'name' => 'LiveChat',
                'description' => 'LiveChat',
                'image' => 'livechat.png',
                'slug' => 'livechat',
                'status' => 0,
                'installed' => 0,
                'activated' => 0,
                'product_id' => '5C9917B8',
                'current_version' => '0.0.1',
                'created_at' => '2022-01-31 18:36:32',
                'updated_at' => '2022-11-02 21:05:14',
                'dev' => 0,
            ],
        ]);

        DB::table('frontends')->insert([
            [
                'id' => 92,
                'data_keys' => 'seo.data',
                'data_values' => '{"seo_image":"1","social_title":"Bicrypto","social_description":"Bicrypto - Crypto Trading Platform, Exchanges, KYC, Charting Library, Wallets, Binary Trading, Forex","keywords":["Crypto Trading Platform, Exchanges, KYC, Charting Library, Wallets, Binary Trading Platform, News"],"description":"Bicrypto - Crypto Trading Platform, Exchanges, KYC, Charting Library, Wallets, Binary Trading, News, Native trading","image":"61daf61a56f2f1641739802.png"}',
                'updated_at' => '2022-10-15 21:44:36',
                'created_at' => '2021-12-18 14:48:45',
            ],
        ]);
    }
}










