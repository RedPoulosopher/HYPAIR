<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert(
            [
                [
                    'event_id' => 1,
                    'titre' => 'Hypair est de retour !',
                    'description' => "# Hypair est en plein développement mais un site de debug est sorti !  \nFaites un tour sur le site pour voir la nouvelle page d\'accueil et la nouvelle gestion.",
                    'date_apparition' => '2023-05-15 08:00:00',
                    'date_expiration' => null,
                    'entite_id' => 1,
                    "confidentiel" => "0"
                ],
                [
                    'event_id' => 2,
                    'titre' => 'Soirée BDE',
                    'description' => "# Soirée BDE  \nAu programme :  \n* Stand de tir à l\'arc  \n* Stand photo  \n* Bar ouvert  \n* Cocktails et biscuits maison  \n* et plein d\'autres surprises !  \nn\'hésite pas à nous rejoindre le **29 Août** à **18h** !",
                    'date_apparition' => '2023-07-31 08:00:00',
                    'date_expiration' => '2023-08-30 08:00:00',
                    'entite_id' => 13,
                    "confidentiel" => "0"
                ],
                [
                    'event_id' => null,
                    'titre' => 'Photos soirées',
                    'description' => "Les photos de la soirée sont là alors n'hésitez pas à aller les voir !  \n[elles sont ici](https://www.google.com)",
                    'date_apparition' => '2023-08-12 15:00:00',
                    'date_expiration' => null,
                    'entite_id' => 17,
                    "confidentiel" => "1"
                ],
                [
                    'event_id' => 3,
                    'titre' => 'Distribution Caméléon',
                    'description' => "# Le nouveau numéro du Caméléon sort le 30 Août !  \nN'oubliez pas votre numéro avant de manger !  \nÀ la une : les Coulisses de l'Intégration !",
                    'date_apparition' => '2023-08-17 15:00:00',
                    'date_expiration' => '2023-08-31 20:00:00',
                    'entite_id' => 8,
                    "confidentiel" => "0"
                ],
                [
                    'event_id' => 6,
                    'titre' => 'Aprem Jeux',
                    'description' => "# Aprem Jeux avec le BDE de Lille !  \nProfitez d'un cadre calme pour vous détendre avec notre aprem  \nJeux de société et jeux vidéos seront au rendez-vous !",
                    'date_apparition' => '2023-08-17 15:00:00',
                    'date_expiration' => '2023-08-31 20:00:00',
                    'entite_id' => 10,
                    "confidentiel" => "0"
                ],
            ]
        );
    }
}
