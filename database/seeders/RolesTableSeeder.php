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
        array(
            [["gerer_actualite" => 1,"gerer_entite" => 1,"gerer_documentation" => 1,"gerer_evenement" => 1,"gerer_membre" => 1,"gerer_projet" => 1,"gerer_ticket" => 1,],'niveau_admin' => 20,['président·e','vice-président·e',]],
            [["gerer_actualite" => 1,"gerer_entite" => 1,"gerer_documentation" => 1,"gerer_evenement" => 0,"gerer_membre" => 0,"gerer_projet" => 0,"gerer_ticket" => 1,],'niveau_admin' => 18,['trésorier·e','vice-trésorier·e',]],
            [["gerer_actualite" => 1,"gerer_entite" => 1,"gerer_documentation" => 1,"gerer_evenement" => 0,"gerer_membre" => 0,"gerer_projet" => 0,"gerer_ticket" => 1,],'niveau_admin' => 17,['secrétaire',]],
            [["gerer_actualite" => 0,"gerer_entite" => 0,"gerer_documentation" => 0,"gerer_evenement" => 0,"gerer_membre" => 0,"gerer_projet" => 0,"gerer_ticket" => 1,],'niveau_admin' => 13,['responsable communication','responsable logistique','responsable pôle monde', 'responsable pôle Nord', 'responsable pôle MEUD', 'responsable bar', 'responsable spectacle', 'responsable soirée', 'responsable décoration', 'responsable restauration/hébergement', 'responsable sponsorisation', 'responsable animation', 'responsable WEI']],
            [["gerer_actualite" => 0,"gerer_entite" => 0,"gerer_documentation" => 0,"gerer_evenement" => 0,"gerer_membre" => 0,"gerer_projet" => 0,"gerer_ticket" => 1,],'niveau_admin' => 8,['pôle communication','pôle logistique','pôle monde', 'pôle Nord', 'pôle MEUD', 'pôle bar', 'pôle spectacle', 'pôle soirée', 'pôle décoration', 'pôle restauration/hébergement', 'pôle sponsorisation', 'pôle animation', 'pôle wei',]],
            [["gerer_actualite" => 0,"gerer_entite" => 0,"gerer_documentation" => 0,"gerer_evenement" => 0,"gerer_membre" => 0,"gerer_projet" => 0,"gerer_ticket" => 0,],'niveau_admin' => 5,['membre',]],
            [["gerer_actualite" => 0,"gerer_entite" => 0,"gerer_documentation" => 0,"gerer_evenement" => 0,"gerer_membre" => 0,"gerer_projet" => 0,"gerer_ticket" => 0,],'niveau_admin' => 2,['abonné·e',]],
            [["gerer_actualite" => 0,"gerer_entite" => 0,"gerer_documentation" => 0,"gerer_evenement" => 0,"gerer_membre" => 0,"gerer_projet" => 0,"gerer_ticket" => 0,],'niveau_admin' => 2,['public',]],
        );
        DB::table('roles')->insert([
            [
                'label' => 'président.e',
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