<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use \App\Models\Entite;
use App\Services\GestionLogo;

class SeederProduction extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
$documentation_courte = <<<EOT
Tu ne nous connais pas. Et pourtant nous sommes dans les murs, les couloirs, les chambres, les sous-sols, nous sommes partout. Certains te diront que nous sommes une espèce méconnue, peut-être même une secte de l’ombre vénérant les serveurs de la meud. Mais ne te laisse pas duper, nous sommes comme toi, comme lui, comme elle, des étudiants de cette école qui ne veulent pas rester dans l’ignorance devant tous les possibles que nous offre l’informatique. Nous sommes l’Association Informatique et Réseaux !

Tu n’es pas très doué avec un clavier mais tu es curieux et tu souhaites apprendre à allumer ton ordi alors tu es le bienvenu. Un nouvel Air est en marche, rejoins-nous vite !
EOT;

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

            'description_courte' => $documentation_courte,
            
            'description_md' => null,
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

        $this->call(ReseauxSociauxListeSeeder::class);
        $this->call(ReseauxSociauxSeeder::class);
    }
}
