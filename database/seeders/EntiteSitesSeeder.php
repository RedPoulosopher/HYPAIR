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
        ]);
    }
}
