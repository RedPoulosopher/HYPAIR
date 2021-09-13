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
                'slug' => 'AIR',
                'bureau_de_ratachement' => 'BDE',
                'email' => 'air@etu.imt-nord-europe.fr',
                'annee_creation' => '2010',
                'description' => 'Association d\'informatique et réseau',
                'couleur_clair' => '#C20502',
                'couleur_sombre' => '#FF1210',
            ],
            [
                'nom' => 'BDE',
                'slug' => 'BDE',
                'bureau_de_ratachement' => null,
                'email' => 'bde@etu.imt-nord-europe.fr',
                'annee_creation' => '2010',
                'description' => 'Bureau des élèves',
                'couleur_clair' => '#C20502',
                'couleur_sombre' => '#FF1210',
            ],
        ]);
    }
}
