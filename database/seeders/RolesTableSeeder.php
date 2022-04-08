<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'label' => 'président·e',
                'niveau_admin' => 7,
                "gerer_actualite" => 1,
                "gerer_entite" => 1,
                "gerer_documentation" => 1,
                "gerer_evenement" => 1,
                "gerer_membre" => 1,
                "gerer_projet" => 1,
                "gerer_ticket" => 1,
            ],
            [
                'label' => 'vice-président·e',
                'niveau_admin' => 7,
                "gerer_actualite" => 1,
                "gerer_entite" => 1,
                "gerer_documentation" => 1,
                "gerer_evenement" => 1,
                "gerer_membre" => 1,
                "gerer_projet" => 1,
                "gerer_ticket" => 1,
            ],
            [
                'label' => 'trésorier·e',
                'niveau_admin' => 5,
                "gerer_actualite" => 1,
                "gerer_entite" => 1,
                "gerer_documentation" => 1,
                "gerer_evenement" => 0,
                "gerer_membre" => 0,
                "gerer_projet" => 0,
                "gerer_ticket" => 1,
            ],
            [
                'label' => 'secrétaire',
                'niveau_admin' => 5,
                "gerer_actualite" => 1,
                "gerer_entite" => 1,
                "gerer_documentation" => 1,
                "gerer_evenement" => 1,
                "gerer_membre" => 1,
                "gerer_projet" => 1,
                "gerer_ticket" => 1,
            ],
            [
                'label' => 'responsable communication',
                'niveau_admin' => 4,
                "gerer_actualite" => 1,
                "gerer_entite" => 0,
                "gerer_documentation" => 1,
                "gerer_evenement" => 1,
                "gerer_membre" => 0,
                "gerer_projet" => 1,
                "gerer_ticket" => 0,
            ],
            [
                'label' => 'membre',
                'niveau_admin' => 1,
                "gerer_actualite" => 0,
                "gerer_entite" => 0,
                "gerer_documentation" => 0,
                "gerer_evenement" => 0,
                "gerer_membre" => 0,
                "gerer_projet" => 0,
                "gerer_ticket" => 0,
            ],
            [
                'label' => 'public',
                'niveau_admin' => 0,
                "gerer_actualite" => 0,
                "gerer_entite" => 0,
                "gerer_documentation" => 0,
                "gerer_evenement" => 0,
                "gerer_membre" => 0,
                "gerer_projet" => 0,
                "gerer_ticket" => 0,
            ]
        ]);
    }
}