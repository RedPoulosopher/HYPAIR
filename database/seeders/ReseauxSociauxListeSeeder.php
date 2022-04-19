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
                'color' => 0x5271ff,
                'pre_url' => 'https://discord.gg/',
            ],
            [
                'nom' => 'Facebook',
                'color' => 0x3b5897,
                'pre_url' => 'https://www.facebook.com/',
            ],
            [
                'nom' => 'Linkedin',
                'color' => 0x007db8,
                'pre_url' => 'https://www.linkedin.com/in/',
            ],
            [
                'nom' => 'WhatsApp',
                'color' => 0x15b32a,
                'pre_url' => 'https://chat.whatsapp.com/',
            ],
            [
                'nom' => 'Signal',
                'color' => 0x3b5998,
                'pre_url' => "contactez l'AIR",
            ],
            [
                'nom' => 'Twitter',
                'color' => 0x00acff,
                'pre_url' => 'https://twitter.com/',
            ],
            [
                'nom' => 'Instagram',
                'color' => 0xd849d1,
                'pre_url' => 'https://www.instagram.com/',
            ],
            [
                'nom' => 'Tiktok',
                'color' => 0x7537a2,
                'pre_url' => "contactez l'AIR",
            ],
            [
                'nom' => 'Twitch',
                'color' => 0x7537a2,
                'pre_url' => 'https://www.twitch.tv/',
            ],
            [
                'nom' => 'Snapchat',
                'color' => 0xf8de02,
                'pre_url' => "contactez l'AIR",
            ],
        ]);
    }
}
