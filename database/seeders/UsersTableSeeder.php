<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'email' => 'marc.bresson@etu.imt-nord-europe.fr',
                'password' => '',
                'langue_pref' => 'fr',
                'promo' => 'FISE2023',
                'chambre' => 'st 0004',
                'residence' => 'L',
                'telephone' => '+33692545632',
            ],
            [
                'nom' => 'Michel',
                'prenom' => 'Dupont',
                'email' => 'michel.dupont@etu.imt-nord-europe.fr',
                'password' => '',
                'langue_pref' => 'en',
                'promo' => 'FISE2021',
                'chambre' => '1018',
                'residence' => 'L',
                'telephone' => '+33589465132',
            ],
        ]);
    }
}
