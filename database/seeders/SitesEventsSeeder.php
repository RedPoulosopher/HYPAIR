<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelevenements;
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
                'site_id' => 1,
                'evenement_id' => 1,
            ],
            [
                'site_id' => 2,
                'evenement_id' => 1,
            ],
            [
                'site_id' => 4,
                'evenement_id' => 2,
            ],
            [
                'site_id' => 2,
                'evenement_id' => 3,
            ],
            [
                'site_id' => 1,
                'evenement_id' => 4,
            ],
            [
                'site_id' => 2,
                'evenement_id' => 4,
            ],
            [
                'site_id' => 1,
                'evenement_id' => 5,
            ],
        ]);
    }
}
