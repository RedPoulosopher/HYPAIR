<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeederProduction extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entites')->insert([
            'nom' => 'AIR',
            'uid' => 'air',
            'bureau_de_ratachement' => 'bde',
            'annee_creation' => '2010',
            'type' => 'comité',
            'sites' => '["douai","lille"]',
            'categories' => '["informatique","réseau"]',
            'couleur_claire' => '#c6152a',
            'couleur_sombre' => '#cc3345',
            'couleur_police_accentuation_claire' => '#000000',
            'couleur_police_accentuation_sombre' => '#FFFFFF',
            'courriel' => 'air@etu.imt-nord-europe.fr',
            'alias' => 'air@etu.imt-nord-europe.fr',

            'description_courte' => 'air@etu.imt-nord-europe.fr',
            'description' => 'air@etu.imt-nord-europe.fr',
        ]);

        $entite_id = Entite::where('uid', "air")->first()->id;
        GestionLogo::stocker_logo_depuis_url("https://capa.etu.imt-lille-douai.fr/img/logoAsso/air.png", $entite_id);
        
        $this->call(RolesTableSeeder::class);

        DB::table('users')->insert([
            [
                'nom' => 'Marc',
                'prenom' => 'Bresson',
                'uid' => 'marc.bresson',
                'password' => Hash::make("z&mWJRVVzT2WC9"),
            ],
        ]);

        DB::table('membres')->insert([
            [
                'entite_id' => '1',
                'user_id' => '1',
                'role_id' => '1',
                'fin_mandat' => '2022-08-01',
                'created_at' => '2021-03-01'
            ],
        ]);
    }
}
