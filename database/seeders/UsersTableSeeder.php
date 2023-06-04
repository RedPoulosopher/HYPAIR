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
                'nom' => 'Mata',
                'prenom' => 'Arthur',
                'uid' => 'arthur.mata',
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
            [
                'nom' => 'Sparrow',
                'prenom' => 'Jack',
                'uid' => 'jack.sparrow',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
            ],
            [
                'nom' => 'Bachelet',
                'prenom' => 'Rémi',
                'uid' => 'remy.bachelet',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
            ],
        ]);
    }
}
