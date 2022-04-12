<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'nom' => 'Marc',
                'prenom' => 'Bresson',
                'uid' => 'marc.bresson',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
            ],
            [
                'nom' => 'Michel',
                'prenom' => 'Dupont',
                'uid' => 'michel.dupont',
                'password' => Hash::make("test"),
                'langue_pref' => 'en',
            ],
        ]);
    }
}
