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
                'annee_creation' => '2010',
                'type' => 'club',
                'sites' => '["douai","lille"]',
                'couleur_claire' => '#c6152a',
                'couleur_sombre' => '#cc3345',
            ],
            [
                'nom' => 'BDE',
                'uid' => 'bde',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'sites' => '["douai"]',
                'couleur_claire' => '#C20502',
                'couleur_sombre' => '#FF1210',
            ],
            [
                'nom' => 'BDE Lille',
                'uid' => 'bde-lille',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'sites' => '["lille"]',
                'couleur_claire' => '#C20502',
                'couleur_sombre' => '#FF1210',
            ],
            [
                'nom' => "Cart'naval",
                'uid' => 'cartnaval',
                'bureau_de_ratachement' => "bda",
                'annee_creation' => '2020',
                'type' => 'liste',
                'sites' => '["douai"]',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
            ],
            [
                'nom' => "dracul'art",
                'uid' => 'draculart',
                'bureau_de_ratachement' => "bda",
                'annee_creation' => '2021',
                'type' => 'liste',
                'sites' => '["douai"]',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
            ],
            [
                'nom' => "club méca",
                'uid' => 'meca',
                'bureau_de_ratachement' => "bde",
                'annee_creation' => '2010',
                'type' => 'club',
                'sites' => '["douai"]',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
            ],
            [
                'nom' => "BDS",
                'uid' => 'bds',
                'bureau_de_ratachement' => 'bds',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'sites' => '["douai"]',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
            ],
            [
                'nom' => "BDA",
                'uid' => 'bda',
                'bureau_de_ratachement' => 'bda',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'sites' => '["douai"]',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
            ],
            [
                'nom' => "BDH",
                'uid' => 'bdh',
                'bureau_de_ratachement' => 'bdh',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'sites' => '["douai"]',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
            ],
        ]);
    }
}
