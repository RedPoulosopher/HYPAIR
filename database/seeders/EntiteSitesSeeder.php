<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntiteSitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entite_sites')->insert([
            [
                'entite_id' => 1,
                'site_id' => 1,
            ],
            [
                'entite_id' => 1,
                'site_id' => 2,
            ],
            [
                'entite_id' => 14,
                'site_id' => 2,
            ],
            [
                'entite_id' => 13,
                'site_id' => 1,
            ],
            [
                'entite_id' => 16,
                'site_id' => 1,
            ],
            [
                'entite_id' => 8,
                'site_id' => 1,
            ],
            [
                'entite_id' => 6,
                'site_id' => 1,
            ],
            [
                'entite_id' => 11,
                'site_id' => 1,
            ],
            [
                'entite_id' => 2,
                'site_id' => 1,
            ],
            [
                'entite_id' => 12,
                'site_id' => 1,
            ],
        ]);
    }
}
