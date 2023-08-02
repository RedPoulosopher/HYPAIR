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
                'couleur' => '#7289DA',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://discord.gg/',
            ],
            [
                'nom' => 'Facebook',
                'couleur' => '#4267B2',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://www.facebook.com/',
            ],
            [
                'nom' => 'Linkedin',
                'couleur' => '#0A66C2',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://www.linkedin.com/in/',
            ],
            [
                'nom' => 'WhatsApp',
                'couleur' => '#25D366',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://chat.whatsapp.com/',
            ],
            [
                'nom' => 'Signal',
                'couleur' => '#3777F0',
                'couleur_police' => '#ffffff',
                'pre_url' => "contactez l'AIR",
            ],
            [
                'nom' => 'Twitter',
                'couleur' => '#1DA1F2',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://twitter.com/',
            ],
            [
                'nom' => 'Instagram',
                'couleur' => '#F77737,#833AB4',
                'couleur_police' => '#ffffff',
                'pre_url' => 'https://www.instagram.com/',
            ],
            [
                'nom' => 'Tiktok',
                'couleur' => '#ff0050,#00f2ea',
                'couleur_police' => '#ffffff',
                'pre_url' => "contactez l'AIR",
            ],
            [
                'nom' => 'Twitch',
                'couleur' => '#9146FF',
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
