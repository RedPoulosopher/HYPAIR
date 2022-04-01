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
                'association_id' => 1,
                'titre' => "Evenement",
                'slug' => "coucou",
                'description' => 'doc pour préciser le contenu',
                'temps_debut' => '2022-04-12 11:00:00',
                'temps_fin' => '2022-04-12 16:00:00',
                'lieu' => 'Meud',
                'max_participation' => 20,
            ],[
                'association_id' => 2,
                'titre' => "soirée BDE",
                'slug' => "hello",
                'description' => 'soirée du bde',
                'temps_debut' => '2022-04-10 18:00:00',
                'temps_fin' => '2022-04-12 23:00:00',
                'lieu' => 'Meud',
                'max_participation' => 200,
            ],[
                'association_id' => 3,
                'titre' => "Aprems",
                'slug' => "helloo",
                'description' => 'soirée du bde',
                'temps_debut' => '2022-03-30 18:00:00',
                'temps_fin' => '2022-04-02 23:00:00',
                'lieu' => 'Meud',
                'max_participation' => 200,
            ]
        ]);
    }
}