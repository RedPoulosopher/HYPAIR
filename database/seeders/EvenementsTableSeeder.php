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
                'association_id' => '1',
                'titre' => "Soirée",
                'slug' => "soiree",
                'description' => 'Soirée de folie',
                'temps_debut' => '2021-12-31 11:00:00',
                'temps_fin' => '2021-12-31 16:00:00',
                'lieu' => 'Meud',
                'max_participation' => 20,
                'validation' => "1",
            ]
        ]);
    }
}