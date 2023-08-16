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
                'titre' => "Evenement",
                'slug' => "coucou",
                'description' => 'doc pour préciser le contenu',
                'temps_debut' => '2022-04-12 11:00:00',
                'temps_fin' => '2022-04-12 16:00:00',
                'lieu' => 'Meud',
                'max_participation' => 20,
                'validation' => "1",
                'pour_cotisant' => "1",
                'date_apparition' => '2022-04-12 08:00:00',
                "confidentiel" => "0"
            ], [
                'entite_id' => 2,
                'titre' => "soirée BDE",
                'slug' => "hello",
                'description' => 'soirée du bde',
                'temps_debut' => '2022-07-20 18:00:00',
                'temps_fin' => '2022-07-20 23:00:00',
                'lieu' => 'Meud',
                'max_participation' => 200,
                'pour_cotisant' => "0",
                'validation' => "1",
                'date_apparition' => '2022-04-12 08:00:00',
                "confidentiel" => "0"
            ], [
                'entite_id' => 3,
                'titre' => "Aprems",
                'slug' => "helloo",
                'description' => 'soirée du bde',
                'temps_debut' => '2022-03-30 18:00:00',
                'temps_fin' => '2022-04-02 23:00:00',
                'lieu' => 'Meud',
                'max_participation' => 200,
                'pour_cotisant' => "1",
                'validation' => "1",
                'date_apparition' => '2022-04-12 20:00:00',
                "confidentiel" => "0"
            ], [
                'entite_id' => 1,
                'titre' => "Soirée",
                'slug' => "soiree",
                'description' => 'Soirée de folie',
                'temps_debut' => '2022-12-31 11:00:00',
                'temps_fin' => '2022-12-31 16:00:00',
                'lieu' => 'Meud',
                'max_participation' => 20,
                'pour_cotisant' => "1",
                'validation' => "1",
                'date_apparition' => '2023-04-12 08:00:00',
                "confidentiel" => "0"
            ], [
                'entite_id' => 1,
                'titre' => "Bonjour",
                'slug' => "bonjour",
                'description' => 'Bonjour à tous, ceci est un évènement test pour vérifier que tout fonctionne correctement.',
                'temps_debut' => '2022-07-10 11:00:00',
                'temps_fin' => '2022-07-10 11:00:00',
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
