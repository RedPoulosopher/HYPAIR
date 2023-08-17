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
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'couleur_claire' => '#C20502',
                'couleur_sombre' => '#FF1210',
                'description_courte' => 'Bureau des Elèves de Douai',
                'description_md' => "# Bureau des Elèves de Douai\nBienvenue au BDE ! Ici, on organise des évènements et des soirées, alors si tu veux cotiser [c'est par ici](https://www.youtube.com/watch?v=dQw4w9WgXcQ)"
            ],
            [
                'nom' => 'BDE Lille',
                'uid' => 'bde_lille',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'couleur_claire' => '#C20502',
                'couleur_sombre' => '#FF1210',
                'description_courte' => 'Bureau des Eleves de Lille',
                'description_md' => null
            ],
            [
                'nom' => "BDS",
                'uid' => 'bds',
                'ratachement' => 'bds',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
                'description_courte' => 'Bureau des Sports de Douai',
                'description_md' => null
            ],
            [
                'nom' => "BDA",
                'uid' => 'bda',
                'ratachement' => 'bda',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
                'description_courte' => 'Bureau des Arts de Douai',
                'description_md' => null
            ],
            [
                'nom' => "BDH",
                'uid' => 'bdh',
                'ratachement' => 'bdh',
                'annee_creation' => '2010',
                'type' => 'bureau',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
                'description_courte' => 'Bureau de l\'humanitaire de Douai',
                'description_md' => null
            ],
        ];

        $listes = [
            [
                'nom' => "Cart'naval",
                'uid' => 'cartnaval',
                'ratachement' => "bda",
                'annee_creation' => '2020',
                'type' => 'liste',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
                'description_courte' => 'Liste BDA 2020',
                'description_md' => null
            ],
            [
                'nom' => "dracul'art",
                'uid' => 'draculart',
                'ratachement' => "bda",
                'annee_creation' => '2021',
                'type' => 'liste',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#7132a8',
                'description_courte' => 'Liste BDA 2021',
                'description_md' => null
            ],
        ];

        $asso_bde = [
            [
                'nom' => 'AIR',
                'uid' => 'air',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#c6152a',
                'couleur_sombre' => '#cc3345',
                'description_courte' => 'Association Informatique et Réseaux',
                'description_md' => null
            ],
            [
                'nom' => 'Club méca',
                'uid' => 'meca',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#71d0dd',
                'couleur_sombre' => '#71d0dd',
                'description_courte' => 'Nous sommes le Club Méca',
                'description_md' => null
            ],
            [
                'nom' => "IMT'ternational",
                'uid' => 'imternational',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#e05a47',
                'couleur_sombre' => '#e05a47',
                'description_courte' => 'IMT\'ernational',
                'description_md' => null
            ],
            [
                'nom' => 'Cotrad',
                'uid' => 'cotrad',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#000000',
                'couleur_sombre' => '#ffffff',
                'description_courte' => 'cotrad',
                'description_md' => null
            ],
            [
                'nom' => 'ZeGreenPeas',
                'uid' => 'zegreenpeas',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#679a54',
                'couleur_sombre' => '#679a54',
                'description_courte' => 'ZeGreenPeas',
                'description_md' => null
            ],
            [
                'nom' => 'Egal’IMT',
                'uid' => 'egalimt',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#9a49d5',
                'couleur_sombre' => '#9a49d5',
                'description_courte' => null,
                'description_md' => null

            ],
            [
                'nom' => 'Junior Entreprise',
                'uid' => 'jine',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#01a7c5',
                'couleur_sombre' => '#01a7c5',
                'description_courte' => null,
                'description_md' => null
            ],
            [
                'nom' => 'Le Caméléon déchaîné',
                'uid' => 'cameleon',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#01b531',
                'couleur_sombre' => '#01b531',
                'description_courte' => null,
                'description_md' => null
            ],
            [
                'nom' => 'Douai Moustache Club',
                'uid' => 'dmc',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#000000',
                'couleur_sombre' => '#ffffff',
                'description_courte' => null,
                'description_md' => null
            ],
            [
                'nom' => 'IMTalks',
                'uid' => 'imtalks',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#f8b403',
                'couleur_sombre' => '#f8b403',
                'description_courte' => null,
                'description_md' => null
            ],
            [
                'nom' => 'Club robotique',
                'uid' => 'robotique',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#5271ff',
                'couleur_sombre' => '#5271ff',
                'description_courte' => null,
                'description_md' => null
            ],
            [
                'nom' => 'Club des brasseurs',
                'uid' => 'brasseurs',
                'ratachement' => 'bde',
                'annee_creation' => '2010',
                'type' => 'comité',
                'couleur_claire' => '#eab826',
                'couleur_sombre' => '#eab826',
                'description_courte' => null,
                'description_md' => null
            ],
        ];

        DB::table('entites')->insert($asso_bde);
        DB::table('entites')->insert($bureaux);
        DB::table('entites')->insert($listes);

        $lien_logos = [
        ];

        foreach($asso_bde as $entite){
            $asso_uid = $entite["uid"];
            $entite_id = Entite::where('uid', $asso_uid)->first()->id;
        }
    }
}
