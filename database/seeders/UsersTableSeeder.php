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
                'pronom' => 'Il/Lui',
                'bio' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                'promo' => "CI3"
            ],
            [
                'nom' => 'Mata',
                'prenom' => 'Arthur',
                'uid' => 'arthur.mata',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
                'pronom' => 'Il/Lui',
                'bio' => '',
                'promo' => "CI1"
            ],
            [
                'nom' => 'Pascal',
                'prenom' => 'Mathilde',
                'uid' => 'mathilde.pascal',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
                'pronom' => 'Elle/elle',
                'bio' => '',
                "promo" => "CI2"
            ],
            [
                'nom' => 'Sparrow',
                'prenom' => 'Jack',
                'uid' => 'jack.sparrow',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
                'pronom' => 'Il/Lui',
                'bio' => '',
                'promo' => "CP1"
            ],
            [
                'nom' => 'Bachelet',
                'prenom' => 'Rémi',
                'uid' => 'remy.bachelet',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
                'pronom' => 'Il/Lui',
                'bio' => NULL,
                'promo' => NULL
            ],
            [
                'nom' => 'Lambda',
                'prenom' => 'Utilisateur',
                'uid' => 'utilisateur.lambda',
                'password' => Hash::make("test"),
                'langue_pref' => 'fr',
                'pronom' => 'Il/Lui',
                'bio' => NULL,
                'promo' => NULL
            ],
        ]);
    }
}
