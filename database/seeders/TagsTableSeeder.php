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
                    'name' => 'IMPORTANT',
                    'couleur' => '#BD2020'
                ],
                [
                    'name' => 'Info',
                    'couleur' => '#878686'
                ],
                [
                    'name' => 'Information',
                    'couleur' => '#878686'
                ],
                [
                    'name' => 'Shotgun',
                    'couleur' => '#6a449f'
                ],
                [
                    'name' => 'CAPA',
                    'couleur' => '#23b844'
                ],
                [
                    'name' => 'Gala',
                    'couleur' => '#009F93'
                ],
                [
                    'name' => 'Soirée',
                    'couleur' => '#144b60'
                ],
                [
                    'name' => 'Moitage',
                    'couleur' => '#7c5446'
                ],
                [
                    'name' => 'Art',
                    'couleur' => '#5568FF'
                ],
                [
                    'name' => 'Tournoi',
                    'couleur' => '#d14f06'
                ],
                [
                    'name' => 'Jeux vidéos',
                    'couleur' => '#881133'
                ],
                [
                    'name' => 'Photos',
                    'couleur' => '#AC3232'
                ],
                [
                    'name' => 'Campagnes',
                    'couleur' => '#d56d5e'
                ],
                [
                    'name' => 'Bénévolat',
                    'couleur' => '#9f2462'
                ],
                [
                    'name' => 'Aprem',
                    'couleur' => '#cf7222'
                ],
                [
                    'name' => 'Allo',
                    'couleur' => '#F24333'
                ],
            ]
        );
    }
}
