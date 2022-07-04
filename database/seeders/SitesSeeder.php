<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sites')->insert([
            [
                'label' => 'douai'
            ],
            [
                'label' => 'lille'
            ],
            [
                'label' => 'valancienne'
            ],
            [
                'label' => 'dunkerque'
            ],
        ]);
    }
}
