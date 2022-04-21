<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\Entite;
use \App\Services\GestionLogo;

class EntitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bureaux = [
            [
                'nom' => 'BDE',
                'uid' => 'bde',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'sites' => '["douai"]',
                'categories' => null,
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
                'categories' => null,
                'couleur_claire' => '#C20502',
                'couleur_sombre' => '#FF1210',
            ],
            [
                'nom' => "BDS",
                'uid' => 'bds',
                'bureau_de_ratachement' => 'bds',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'sites' => '["douai"]',
                'categories' => null,
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
                'categories' => null,
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
                'categories' => null,
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
            ],
        ];

        $listes = [
            [
                'nom' => "Cart'naval",
                'uid' => 'cartnaval',
                'bureau_de_ratachement' => "bda",
                'annee_creation' => '2020',
                'type' => 'liste',
                'sites' => '["douai"]',
                'categories' => null,
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
                'categories' => null,
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
            ],
        ];

        $asso_bde = [
            [
                'nom' => 'AIR',
                'uid' => 'air',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai","lille"]',
                'categories' => '["informatique","réseau"]',
                'couleur_claire' => '#c6152a',
                'couleur_sombre' => '#cc3345',
            ],
            [
                'nom' => 'Club méca',
                'uid' => 'meca',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["mécanique","vélo","réparation"]',
                'couleur_claire' => '#71d0dd',
                'couleur_sombre' => '#71d0dd',
            ],
            [
                'nom' => "IMT'ternational",
                'uid' => 'imternational',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["culture","découverte"]',
                'couleur_claire' => '#e05a47',
                'couleur_sombre' => '#e05a47',
            ],
            [
                'nom' => 'Cotrad',
                'uid' => 'cotrad',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["traditions","miniens"]',
                'couleur_claire' => '#000000',
                'couleur_sombre' => '#ffffff',
            ],
            [
                'nom' => 'ZeGreenPeas',
                'uid' => 'zegreenpeas',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["écologie","transition"]',
                'couleur_claire' => '#679a54',
                'couleur_sombre' => '#679a54',
            ],
            [
                'nom' => 'Egal’IMT',
                'uid' => 'egalimt',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["égalité des droits"]',
                'couleur_claire' => '#9a49d5',
                'couleur_sombre' => '#9a49d5',
            ],
            [
                'nom' => 'Junior Entreprise',
                'uid' => 'jine',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["professionel","travail"]',
                'couleur_claire' => '#01a7c5',
                'couleur_sombre' => '#01a7c5',
            ],
            [
                'nom' => 'Le Caméléon déchaîné',
                'uid' => 'cameleon',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["presse","interview"]',
                'couleur_claire' => '#01b531',
                'couleur_sombre' => '#01b531',
            ],
            [
                'nom' => 'Douai Moustache Club',
                'uid' => 'dmc',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["cuir","moustache"]',
                'couleur_claire' => '#000000',
                'couleur_sombre' => '#ffffff',
            ],
            [
                'nom' => 'IMTalks',
                'uid' => 'imtalks',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["débat","conférence"]',
                'couleur_claire' => '#f8b403',
                'couleur_sombre' => '#f8b403',
            ],
            [
                'nom' => 'Club robotique',
                'uid' => 'robotique',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["robotique","mécanique"]',
                'couleur_claire' => '#5271ff',
                'couleur_sombre' => '#5271ff',
            ],
            [
                'nom' => 'Club des brasseurs',
                'uid' => 'brasseurs',
                'bureau_de_ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'sites' => '["douai"]',
                'categories' => '["bière"]',
                'couleur_claire' => '#eab826',
                'couleur_sombre' => '#eab826',
            ],
        ];

        DB::table('entites')->insert($asso_bde);
        DB::table('entites')->insert($bureaux);
        DB::table('entites')->insert($listes);

        $lien_logos = [
            "bde"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/bde.png",
            "air"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/air.png",
            "meca"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/meca.png",
            "imternational"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/imternational.png",
            "cotrad"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/cotrad.png",
            "zegreenpeas"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/greenpeas.png",
            "egalimt"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/egalimt.png",
            "jine"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/artemis.png",
            "cameleon"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/cameleon.png",
            "dmc"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/moustache.png",
            "imtalks"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/talks.png",
            "robotique"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/robot.png",
            "brasseurs"=>"https://capa.etu.imt-lille-douai.fr/img/logoAsso/brasseur.png",
        ];

        // foreach($asso_bde as $entite){
        //     $asso_uid = $entite["uid"];
        //     $entite_id = Entite::where('uid', $asso_uid)->first()->id;
        //     GestionLogo::stocker_logo_depuis_url($lien_logos[$asso_uid], $entite_id);
        // }
    }
}
