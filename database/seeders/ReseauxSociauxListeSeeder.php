<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReseauxSociauxListeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reseaux_sociaux_liste')->insert([
            [
                'nom' => 'Discord',
                'couleur' => '#5271ff',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://discord.gg/',
            ],
            [
                'nom' => 'Facebook',
                'couleur' => '#3b5897',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://www.facebook.com/',
            ],
            [
                'nom' => 'Linkedin',
                'couleur' => '#007db8',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://www.linkedin.com/in/',
            ],
            [
                'nom' => 'WhatsApp',
                'couleur' => '#15b32a',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://chat.whatsapp.com/',
            ],
            [
                'nom' => 'Signal',
                'couleur' => '#3b5998',
                'couleur_police' => '#ffffff',
                'pre_url' => "contactez l'AIR",
            ],
            [
                'nom' => 'Twitter',
                'couleur' => '#00acff',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://twitter.com/',
            ],
            [
                'nom' => 'Instagram',
                'couleur' => '#d849d1',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://www.instagram.com/',
            ],
            [
                'nom' => 'Tiktok',
                'couleur' => '#7537a2',
                'couleur_police' => '#ffffff',
                'pre_url' => "contactez l'AIR",
            ],
            [
                'nom' => 'Twitch',
                'couleur' => '#7537a2',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://www.twitch.tv/',
            ],
            [
                'nom' => 'Snapchat',
                'couleur' => '#f8de02',
                'couleur_police' => '#ffffff',
                'pre_url' => "contactez l'AIR",
            ],
        ]);
    }
}
