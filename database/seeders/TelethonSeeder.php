<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TelethonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // Articles en vente
        DB::table('item_ventes')->insert([
            [
                'uid' => Str::uuid(),
                'label' => 'Crêpe',
                'value' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uid' => Str::uuid(),
                'label' => 'Gaufre',
                'value' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uid' => Str::uuid(),
                'label' => 'Bonbon',
                'value' => '0.50',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Équipes
        DB::table('teams')->insert([
            [
                'uid' => Str::uuid(),
                'label' => 'Équipe rouge',
                'couleur' => '#FF0000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uid' => Str::uuid(),
                'label' => 'Équipe bleue',
                'couleur' => '#0000FF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uid' => Str::uuid(),
                'label' => 'Équipe verte',
                'couleur' => '#008000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uid' => Str::uuid(),
                'label' => 'Équipe jaune',
                'couleur' => '#FFFF00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
