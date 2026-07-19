<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;
use Illuminate\Support\Facades\DB;

class ConstantesSeeder extends Seeder
{
    public function run(): void
    {
        $sites = [
            ['label' => 'Douai'],
            ['label' => "Villeneuve-d'Ascq"],
            ['label' => 'Dunkerque'],
            ['label' => 'Valenciennes'],
            ['label' => 'Alençon'],
        ];

        foreach ($sites as $site) {
            Site::firstOrCreate($site);
        }

        $reseaux_sociaux = [
            [
                'nom' => 'Facebook',
                'color' => '#1877F2',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://www.facebook.com/{page}',
                'placeholder_user' => 'https://www.facebook.com/{username}',
            ],
            [
                'nom' => 'Instagram',
                'color' => '#E4405F',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://www.instagram.com/{account}',
                'placeholder_user' => 'https://www.instagram.com/{username}',
            ],
            [
                'nom' => 'X (Twitter)',
                'color' => '#000000',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://x.com/{account}',
                'placeholder_user' => 'https://x.com/{username}',
            ],
            [
                'nom' => 'LinkedIn',
                'color' => '#0A66C2',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://www.linkedin.com/company/{company}',
                'placeholder_user' => 'https://www.linkedin.com/in/{username}',
            ],
            [
                'nom' => 'TikTok',
                'color' => '#010101',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://www.tiktok.com/@{account}',
                'placeholder_user' => 'https://www.tiktok.com/@{username}',
            ],
            [
                'nom' => 'YouTube',
                'color' => '#FF0000',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://www.youtube.com/@{channel}',
                'placeholder_user' => 'https://www.youtube.com/@{channel}',
            ],
            [
                'nom' => 'Snapchat',
                'color' => '#FFFC00',
                'font_color' => '#000000',
                'placeholder_entite' => 'https://www.snapchat.com/add/{account}',
                'placeholder_user' => 'https://www.snapchat.com/add/{username}',
            ],
            [
                'nom' => 'Pinterest',
                'color' => '#E60023',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://www.pinterest.com/{account}',
                'placeholder_user' => 'https://www.pinterest.com/{username}',
            ],
            [
                'nom' => 'Reddit',
                'color' => '#FF4500',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://www.reddit.com/r/{subreddit}',
                'placeholder_user' => 'https://www.reddit.com/user/{username}',
            ],
            [
                'nom' => 'GitHub',
                'color' => '#181717',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://github.com/{org}',
                'placeholder_user' => 'https://github.com/{username}',
            ],
            [
                'nom' => 'GitLab',
                'color' => '#FC6D26',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://gitlab.com/{group}',
                'placeholder_user' => 'https://gitlab.com/{username}',
            ],
            [
                'nom' => 'Discord',
                'color' => '#5865F2',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://discord.gg/{invite}',
                'placeholder_user' => 'https://discord.gg/{invite}',
            ],
            [
                'nom' => 'WhatsApp',
                'color' => '#25D366',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://wa.me/{number}',
                'placeholder_user' => 'https://wa.me/{number}',
            ],
            [
                'nom' => 'Telegram',
                'color' => '#26A5E4',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://t.me/{channel}',
                'placeholder_user' => 'https://t.me/{username}',
            ],
            [
                'nom' => 'Twitch',
                'color' => '#9146FF',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://www.twitch.tv/{channel}',
                'placeholder_user' => 'https://www.twitch.tv/{username}',
            ],
            [
                'nom' => 'Threads',
                'color' => '#000000',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://www.threads.net/@{account}',
                'placeholder_user' => 'https://www.threads.net/@{username}',
            ],
            [
                'nom' => 'Mastodon',
                'color' => '#6364FF',
                'font_color' => '#FFFFFF',
                'placeholder_entite' => 'https://mastodon.social/@{account}',
                'placeholder_user' => 'https://mastodon.social/@{username}',
            ],
        ];

        foreach ($reseaux_sociaux as $reseau_social) {
            $exists = DB::table('reseaux_sociaux')
                ->where('nom', $reseau_social['nom'])
                ->exists();

            if (!$exists) {
                DB::table('reseaux_sociaux')->insert($reseau_social);
            }
        }
    }
}