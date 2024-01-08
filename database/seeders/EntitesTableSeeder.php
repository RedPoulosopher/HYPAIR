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
                'annee_fin' => '2021',
                'type' => 'liste',
                'couleur_claire' => '#7132a8',
                'couleur_sombre' => '#345678',
                'description_courte' => 'Liste BDA 2020',
                'description_md' => null,
                'score' => null
            ],
            [
                'nom' => "dracul'art",
                'uid' => 'draculart',
                'ratachement' => "bda",
                'annee_creation' => '2021',
                'annee_fin' => '2022',
                'type' => 'liste',
                'couleur_claire' => '#123456',
                'couleur_sombre' => '#234567',
                'description_courte' => 'Liste BDA 2021',
                'description_md' => null,
                'score' => null
            ],
            [
                'nom' => "Queen Art's Revenge",
                'uid' => 'qar',
                'ratachement' => "bda",
                'annee_creation' => '2022',
                'annee_fin' => '2023',
                'type' => 'liste',
                'couleur_claire' => '#456789',
                'couleur_sombre' => '#56789A',
                'description_courte' => 'Best liste BDA 2023',
                'description_md' => null,
                'score' => null
            ],
            [
                'nom' => "Saucifl'art",
                'uid' => 'sauciflart',
                'ratachement' => "bda",
                'annee_creation' => '2023',
                'annee_fin' => '2024',
                'type' => 'liste',
                'couleur_claire' => '#789012',
                'couleur_sombre' => '#357951',
                'description_courte' => 'Liste BDA 2024 fan de sauccisson',
                'description_md' => null,
                'score' => '25.6'
            ],
            [
                'nom' => "T'artine",
                'uid' => 'tartine',
                'ratachement' => "bda",
                'annee_creation' => '2023',
                'annee_fin' => '2024',
                'type' => 'liste',
                'couleur_claire' => '#147147',
                'couleur_sombre' => '#852369',
                'description_courte' => 'Liste BDA 2024 fan de pain',
                'description_md' => null,
                'score' => '35.9'
            ],
            [
                'nom' => "Barbapap'art",
                'uid' => 'barbapapart',
                'ratachement' => "bda",
                'annee_creation' => '2023',
                'annee_fin' => '2023=4',
                'type' => 'liste',
                'couleur_claire' => '#951456',
                'couleur_sombre' => '#654987',
                'description_courte' => 'Liste BDA 2024 fan de barbapapa',
                'description_md' => null,
                'score' => '89.1'
            ],
            [
                'nom' => "Absolu'mant",
                'uid' => 'absolumant',
                'ratachement' => "bdh",
                'annee_creation' => '2023',
                'annee_fin' => '2024',
                'type' => 'liste',
                'couleur_claire' => '#128453',
                'couleur_sombre' => '#843574',
                'description_courte' => "Liste BDH 2024 très sûre d'elle",
                'description_md' => null,
                'score' => '3.3'
            ],
            [
                'nom' => "Passionné'man",
                'uid' => 'passionneman',
                'ratachement' => "bdh",
                'annee_creation' => '2023',
                'annee_fin' => '2024',
                'type' => 'liste',
                'couleur_claire' => '#411232',
                'couleur_sombre' => '#645698',
                'description_courte' => 'Liste BDH 2024 vraiment passionnée',
                'description_md' => null,
                'score' => '96.7'
            ],
            [
                'nom' => "Préservat'imt",
                'uid' => 'preservatimt',
                'ratachement' => "bde",
                'annee_creation' => '2023',
                'annee_fin' => '2024',
                'type' => 'liste',
                'couleur_claire' => '#139786',
                'couleur_sombre' => '#146712',
                'description_courte' => 'Liste BDE 2024 avec capotes gratuites',
                'description_md' => null,
                'score' => null
            ],
            [
                'nom' => "Sour'imt",
                'uid' => 'sourimt',
                'ratachement' => "bde",
                'annee_creation' => '2023',
                'annee_fin' => '2024',
                'type' => 'liste',
                'couleur_claire' => '#356486',
                'couleur_sombre' => '#561764',
                'description_courte' => 'Liste BDE 2024 avec souris gratuites',
                'description_md' => null,
                'score' => null
            ],
            [
                'nom' => "Carte Kiw'imt",
                'uid' => 'cartekiwimt',
                'ratachement' => "bde",
                'annee_creation' => '2023',
                'annee_fin' => '2024',
                'type' => 'liste',
                'couleur_claire' => '#789123',
                'couleur_sombre' => '#963147',
                'description_courte' => 'Liste BDE 2024 avec cartes kiwi gratuites',
                'description_md' => null,
                'score' => null
            ],
            // [
            //     'nom' => "Lim'As",
            //     'uid' => 'limas',
            //     'ratachement' => "bds",
            //     'annee_creation' => '2023',
            //     'annee_fin' => '2024',
            //     'type' => 'liste',
            //     'couleur_claire' => '#456654',
            //     'couleur_sombre' => '#789925',
            //     'description_courte' => 'Liste BDS 2024 fan de limaces',
            //     'description_md' => null,
            //     'score' => '100.0'
            // ],
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
                'description_md' => "# L'AIR c'est cool  \nCeci est une description écrite en **Markdown**.  \n\nOn peut également mettre des images !  \n\n![](https://images.unsplash.com/photo-1682685797828-d3b2561deef4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80)  \n\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."
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
