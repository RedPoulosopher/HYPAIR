<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sites_posts')->insert([
            [
                'site_id' => 1,
                'post_id' => 1
            ],
            [
                'site_id' => 1,
                'post_id' => 2
            ],
            [
                'site_id' => 2,
                'post_id' => 2
            ],
            [
                'site_id' => 1,
                'post_id' => 3
            ],
            [
                'site_id' => 1,
                'post_id' => 4
            ],
            [
                'site_id' => 2,
                'post_id' => 4
            ],
            [
                'site_id' => 3,
                'post_id' => 4
            ],
        ]);
    }
}
