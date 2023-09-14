<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sites_users')->insert( [
            [
                "site_id" => 1,
                "user_id" => 1
            ],
            [
                "site_id" => 2,
                "user_id" => 1
            ],
            [
                "site_id" => 3,
                "user_id" => 1
            ],
            [
                "site_id" => 1,
                "user_id" => 2
            ],
            [
                "site_id" => 2,
                "user_id" => 3
            ],
            [
                "site_id" => 4,
                "user_id" => 4
            ],
            [
                "site_id" => 5,
                "user_id" => 4
            ],
            [
                "site_id" => 1,
                "user_id" => 7
            ],
            [
                "site_id" => 2,
                "user_id" => 7
            ],
            [
                "site_id" => 3,
                "user_id" => 7
            ],
            [
                "site_id" => 4,
                "user_id" => 7
            ],
            [
                "site_id" => 5,
                "user_id" => 7
            ],
        ]
        );
    }
}
