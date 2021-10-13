<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'label' => 'président·e',
                'niveau_admin' => 7
            ],
            [
                'label' => 'vice-président·e',
                'niveau_admin' => 6
            ],
            [
                'label' => 'trésorier·e',
                'niveau_admin' => 5
            ],
            [
                'label' => 'secrétaire',
                'niveau_admin' => 5
            ],
            [
                'label' => 'responsable communication',
                'niveau_admin' => 4
            ],
            [
                'label' => 'membre',
                'niveau_admin' => 1
            ]
        ]);
    }
}