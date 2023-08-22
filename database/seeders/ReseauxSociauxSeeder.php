<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReseauxSociauxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reseaux_sociaux')->insert([
            [
                'reseau_sociable_id' => 1,
                'reseau_sociable_type' => 'App\Models\User',
                'reseaux_sociaux_liste_id' => 1,
                'cle' => 'test',
            ],
            [
                'reseau_sociable_id' => 1,
                'reseau_sociable_type' => 'App\Models\User',
                'reseaux_sociaux_liste_id' => 7,
                'cle' => 'test',
            ],
            [
                'reseau_sociable_id' => 1,
                'reseau_sociable_type' => 'App\Models\Entite',
                'reseaux_sociaux_liste_id' => 1,
                'cle' => 'QScNktyb3j',
            ],
            [
                'reseau_sociable_id' => 1,
                'reseau_sociable_type' => 'App\Models\Entite',
                'reseaux_sociaux_liste_id' => 2,
                'cle' => 'AIR.IMT.NE',
            ],
            [
                'reseau_sociable_id' => 1,
                'reseau_sociable_type' => 'App\Models\Entite',
                'reseaux_sociaux_liste_id' => 3,
                'cle' => 'company/air-imt',
            ],
        ]);
    }
}
