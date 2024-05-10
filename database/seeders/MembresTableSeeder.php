<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('membres')->insert([
            [
                'entite_id' => '1',
                'user_id' => '1',
                'role_id' => '1',
                'fin_mandat' => "2050-05-01",
                'created_at' => "2023-03-01",
            ],
            [
                'entite_id' => '8',
                'user_id' => '1',
                'role_id' => '6',
                'fin_mandat' => "2050-05-01",
                'created_at' => "2023-03-01",
            ],
            [
                'entite_id' => '13',
                'user_id' => '2',
                'role_id' => '1',
                'fin_mandat' => "2050-05-01",
                'created_at' => "2023-03-01",
            ],
            [
                'entite_id' => '16',
                'user_id' => '2',
                'role_id' => '2',
                'fin_mandat' => "2050-05-01",
                'created_at' => "2023-03-01",
            ],
            [
                'entite_id' => '9',
                'user_id' => '4',
                'role_id' => '25',
                'fin_mandat' => "2050-05-01",
                'created_at' => "2023-03-01",
            ],
            [
                'entite_id' => '7',
                'user_id' => '3',
                'role_id' => '2',
                'fin_mandat' => "2050-05-01",
                'created_at' => "2023-03-01",
            ],
            [
                'entite_id' => '3',
                'user_id' => '3',
                'role_id' => '3',
                'fin_mandat' => "2050-05-01",
                'created_at' => "2023-03-01",
            ],
            [
                'entite_id' => '10',
                'user_id' => '5',
                'role_id' => '11',
                'fin_mandat' => "2050-05-01",
                'created_at' => "2023-03-01",
            ],
            [
                'entite_id' => '21',
                'user_id' => '5',
                'role_id' => '1',
                'fin_mandat' => "2050-05-01",
                'created_at' => "2023-03-01",
            ],
        ]);
    }
}
