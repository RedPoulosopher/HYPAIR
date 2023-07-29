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
                'description' => 'doc pour préciser le contenu',
                'date_apparition' => '2022-04-10 05:00:00',
                'temps_debut' => '2022-04-12 11:00:00',
                'temps_fin' => '2022-04-12 16:00:00',
                'lieu' => 'Meud',
                'max_participation' => 20,
                'campus_id' => 1,
                'pour_cotisant' => false,
                'is_actualite' => false,
            ], [
                'entite_id' => 2,
                'titre' => "soirée BDE",
                'description' => 'soirée du bde',
                'date_apparition' => '2022-04-10 05:00:00',
                'temps_debut' => '2022-07-20 18:00:00',
                'temps_fin' => '2022-07-20 23:00:00',
                'lieu' => 'Meud',
                'max_participation' => 200,
                'campus_id' => 1,
                'pour_cotisant' => false,
                'is_actualite' => true,
            ], [
                'entite_id' => 3,
                'titre' => "Aprems",
                'description' => 'soirée du bde',
                'date_apparition' => '2022-04-10 05:00:00',
                'temps_debut' => '2022-03-30 18:00:00',
                'temps_fin' => '2022-04-02 23:00:00',
                'lieu' => 'Meud',
                'max_participation' => 200,
                'campus_id' => 2,
                'pour_cotisant' => false,
                'is_actualite' => true,
            ], [
                'entite_id' => '1',
                'titre' => "Soirée",
                'description' => 'Soirée de folie',
                'date_apparition' => '2022-04-10 05:00:00',
                'temps_debut' => '2022-12-31 11:00:00',
                'temps_fin' => '2022-12-31 16:00:00',
                'lieu' => 'Meud',
                'max_participation' => 20,
                'campus_id' => 1,
                'pour_cotisant' => true,
                'is_actualite' => false,
            ], [
                'entite_id' => '1',
                'titre' => "Bonjour",
                'description' => 'Bonjour à tous, ceci est un évènement test pour vérifier que tout fonctionne correctement.',
                'date_apparition' => '2022-04-10 05:00:00',
                'temps_debut' => '2022-07-10 11:00:00',
                'temps_fin' => '2022-07-10 11:00:00',
                'lieu' => 'Salle Nicolas',
                'max_participation' => 400,
                'campus_id' => 2,
                'pour_cotisant' => true,
                'is_actualite' => false,
            ]
        ]);
    }
}
