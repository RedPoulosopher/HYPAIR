<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EvenementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('evenements')->insert([
            [
                'entite_id' => 1,
                'titre' => "Déploiement de Hypair",
                'slug' => "hypair",
                'description' => 'Le site développement de Hypair sera en ligne ! Ne ratez pas ça !',
                'temps_debut' => '2023-08-18 00:00:00',
                'temps_fin' => '2023-08-18 23:59:59',
                'lieu' => 'En ligne',
                'max_participation' => 20,
                'validation' => "1",
                'pour_cotisant' => "1",
                'date_apparition' => '2023-08-17 08:00:00',
                "confidentiel" => "0"
            ], [
                'entite_id' => 13,
                'titre' => "Soirée BDE",
                'slug' => "soireebde",
                'description' => 'La toute première soirée du BDE approche enfin !',
                'temps_debut' => '2023-08-29 18:00:00',
                'temps_fin' => '2023-08-30 3:00:00',
                'lieu' => 'Meud',
                'max_participation' => 200,
                'pour_cotisant' => "0",
                'validation' => "1",
                'date_apparition' => '2023-07-12 08:00:00',
                "confidentiel" => "0"
            ], [
                'entite_id' => 8,
                'titre' => "Distribution Caméléon",
                'slug' => "distribution1",
                'description' => 'Venez chercher votre dernier numéro du Caméléon Déchaîné ! À la une : les Coulisses de l\'intégration !',
                'temps_debut' => '2023-08-30 11:30:00',
                'temps_fin' => '2023-08-30 13:30:00',
                'lieu' => 'Cantine',
                'max_participation' => 100,
                'pour_cotisant' => "1",
                'validation' => "1",
                'date_apparition' => '2022-08-17 10:00:00',
                "confidentiel" => "0"
            ], [
                'entite_id' => 6,
                'titre' => "Atelier VR",
                'slug' => "atelier1",
                'description' => 'Atelier sur l\'égalité avec casque VR puis discussion de vos impressions',
                'temps_debut' => '2023-09-07 09:00:00',
                'temps_fin' => '2023-09-07 12:00:00',
                'lieu' => 'Bourseul',
                'max_participation' => 20,
                'pour_cotisant' => "1",
                'validation' => "1",
                'date_apparition' => '2023-07-12 08:00:00',
                "confidentiel" => "0"
            ], [
                'entite_id' => 15,
                'titre' => "Distribution Tshirt",
                'slug' => "tshirt",
                'description' => 'Venez récupérer le magnifique tshirt du BDS',
                'temps_debut' => '2023-09-07 11:30:00',
                'temps_fin' => '2023-09-07 15:00:00',
                'lieu' => 'Salle Nicolas',
                'max_participation' => 400,
                'validation' => "1",
                'pour_cotisant' => "1",
                'date_apparition' => '2022-04-24 08:00:00',
                "confidentiel" => "1"
            ]
        ]);
    }
}
