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
                'nom' => 'Bresson',
                'prenom' => 'Marc',
                'uid' => 'marc.bresson',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
            ],
            [
                'nom' => 'Dupont',
                'prenom' => 'Michel',
                'uid' => 'michel.dupont',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
            ],
            [
                'nom' => 'Pascal',
                'prenom' => 'Bastien',
                'uid' => 'bastien.pascal',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
            ],
        ]);
    }
}
