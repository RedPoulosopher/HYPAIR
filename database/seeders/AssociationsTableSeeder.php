<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssociationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('associations')->insert([
            [
                'nom' => 'AIR',
                'uid' => 'air',
                'bureau_de_ratachement' => 'bde',
                'courriel' => 'air@etu.imt-nord-europe.fr',
                'annee_creation' => '2010',
                'type' => 'club',
                'sites' => '["douai","lille"]',
                'description' => 'Association d\'informatique et réseau',
                'couleur_claire' => '#c6152a',
                'couleur_sombre' => '#cc3345',
            ],
            [
                'nom' => 'BDE',
                'uid' => 'bde',
                'bureau_de_ratachement' => null,
                'courriel' => 'bde@etu.imt-nord-europe.fr',
                'annee_creation' => '2010',
                'description' => 'Bureau des élèves',
                'type' => 'bureau',
                'sites' => '["lille"]',
                'couleur_claire' => '#C20502',
                'couleur_sombre' => '#FF1210',
            ],
            [
                'nom' => 'cartnaval',
                'uid' => 'cartnaval',
                'bureau_de_ratachement' => "bda",
                'courriel' => null,
                'annee_creation' => '2021',
                'type' => 'liste',
                'sites' => '["douai"]',
                'description' => 'liste BDA',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
            ],
        ]);
    }
}
