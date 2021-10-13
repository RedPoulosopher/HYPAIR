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
                'users_id' => 1,
                'associations_id' => 1,
                'roles_id' => 1,
                'competences' => '["php","js","css","html","python"]',
                'date_rejoint' => '2020-08-17',
            ]
        ]);
    }
}
