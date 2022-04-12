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
                'fin_mandat' => "2023-05-01",
                'created_at' => "2022-03-01",
            ],
            [
                'entite_id' => '2',
                'user_id' => '1',
                'role_id' => '2',
                'fin_mandat' => "2023-05-01",
                'created_at' => "2022-03-01",
            ],
        ]);
    }
}
