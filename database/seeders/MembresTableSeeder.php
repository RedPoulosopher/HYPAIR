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
                'association_uid' => 'AIR',
                'user_id' => '1',
                'role_id' => '1',
            ],
            [
                'association_uid' => 'BDE',
                'user_id' => '1',
                'role_id' => '5',
            ],
        ]);
    }
}
