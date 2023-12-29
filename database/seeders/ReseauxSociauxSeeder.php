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
                'reseau_social_id' => 1,
                'reseau_social_type' => 'App\Models\User',
                'reseaux_sociaux_liste_id' => 1,
                'lien' => 'https://discord.gg/test',
            ],
            [
                'reseau_social_id' => 1,
                'reseau_social_type' => 'App\Models\User',
                'reseaux_sociaux_liste_id' => 7,
                'lien' => 'https://www.instagram.com/test',
            ],
            [
                'reseau_social_id' => 1,
                'reseau_social_type' => 'App\Models\Entite',
                'reseaux_sociaux_liste_id' => 1,
                'lien' => 'https://discord.gg/QScNktyb3j',
            ],
            [
                'reseau_social_id' => 1,
                'reseau_social_type' => 'App\Models\Entite',
                'reseaux_sociaux_liste_id' => 2,
                'lien' => 'https://www.facebook.com/AIR.IMT.NE',
            ],
            [
                'reseau_social_id' => 1,
                'reseau_social_type' => 'App\Models\Entite',
                'reseaux_sociaux_liste_id' => 3,
                'lien' => 'https://www.linkedin.com/in/company/air-imt',
            ],
        ]);
    }
}
