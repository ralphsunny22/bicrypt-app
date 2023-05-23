<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locales')->insert([
            [
                'id' => 1,
                'code' => 'ar',
                'country_code' => 'IQ',
                'title' => 'Arabic',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'code' => 'bn',
                'country_code' => 'IN',
                'title' => 'Bengali',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            // Add the remaining records here
            // ...
            [
                'id' => 20,
                'code' => 'zh',
                'country_code' => 'CN',
                'title' => 'Chinese',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
