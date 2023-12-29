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
                'placeholder_entite' => 'https://discord.gg/...',
                'placeholder_utilisateur' => "Nom d'utilisateur ou ID",
            ],
            [
                'nom' => 'Facebook',
                'couleur' => '#4267B2',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => 'https://www.facebook.com/...',
                'placeholder_utilisateur' => 'https://www.facebook.com/...',
            ],
            [
                'nom' => 'Linkedin',
                'couleur' => '#0A66C2',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => 'https://www.linkedin.com/in/...',
                'placeholder_utilisateur' => 'https://www.linkedin.com/in/...',
            ],
            [
                'nom' => 'WhatsApp',
                'couleur' => '#25D366',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => 'https://chat.whatsapp.com/...',
                'placeholder_individuel' => '+33...',
            ],
            [
                'nom' => 'Signal',
                'couleur' => '#3777F0',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => "Contactez l'AIR",
                'placeholder_individuel' => "Contactez l'AIR",//TODO
            ],
            [
                'nom' => 'Twitter',
                'couleur' => '#1DA1F2',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => 'https://twitter.com/...',
                'placeholder_individuel' => 'https://twitter.com/...',
            ],
            [
                'nom' => 'Instagram',
                'couleur' => '#F77737,#833AB4',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => 'https://www.instagram.com/...',
                'placeholder_individuel' => 'https://www.instagram.com/...',
            ],
            [
                'nom' => 'Tiktok',
                'couleur' => '#ff0050,#00f2ea',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => "https://www.tiktok.com/@...",
                'placeholder_individuel' => "https://www.tiktok.com/@...",
            ],
            [
                'nom' => 'Twitch',
                'couleur' => '#9146FF',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => 'https://www.twitch.tv/...',
                'placeholder_individuel' => 'https://www.twitch.tv/...',
            ],
            [
                'nom' => 'Snapchat',
                'couleur' => '#dcbf05',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => 'https://www.snapchat.com/add/...',
                'placeholder_individuel' => 'https://t.snapchat.com/...',
            ],
            [
                'nom' => 'Linktree',
                'couleur' => '#43E660',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => 'https://linktr.ee/...',
                'placeholder_individuel' => 'https://linktr.ee/...',
                
            ],            
            [
                'nom' => 'Youtube',
                'couleur' => '#FF0000',
                'couleur_police' => '#ffffff',
                'placeholder_entite' => 'https://www.youtube.com/channel/...',
                'placeholder_individuel' => 'https://www.youtube.com/channel/...',
                
            ]
        ]);
    }
}
