<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sites_evenements')->insert([
            [
                'campus_id' => 1,
                'event_id' => 1,
            ],
            [
                'campus_id' => 2,
                'event_id' => 1,
            ],
            [
                'campus_id' => 4,
                'event_id' => 2,
            ],
            [
                'campus_id' => 2,
                'event_id' => 3,
            ],
            [
                'campus_id' => 1,
                'event_id' => 4,
            ],
            [
                'campus_id' => 2,
                'event_id' => 4,
            ],
            [
                'campus_id' => 1,
                'event_id' => 5,
            ],
        ]);
    }
}
