<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert(
            [
                [
                    'name' => 'Soirée',
                    'couleur' => '#CCAA11'
                ],
                [
                    'name' => 'Moitage',
                    'couleur' => '#00BB22'
                ],
                [
                    'name' => 'Art',
                    'couleur' => '#55FFFF'
                ],
                [
                    'name' => 'Tournoi',
                    'couleur' => '#FF6611'
                ],
                [
                    'name' => 'Jeux vidéos',
                    'couleur' => '#881133'
                ],
            ]
        );
    }
}
