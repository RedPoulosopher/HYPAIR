<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use App\Models\points_telethon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TelethonSeeder extends Seeder
{
    public function run(): void
    {
        // ARTICLES EN VENTE
        $items = [
            ['label' => 'Crêpe', 'value' => '2', 'prix' => '2'],
            ['label' => 'Gaufre', 'value' => '2', 'prix' => '2'],
            ['label' => 'Bonbon', 'value' => '0.50', 'prix' => '2'],
        ];

        foreach ($items as $item) {
            \DB::table('item_ventes')->updateOrInsert(
                ['label' => $item['label']],
                [
                    'uid' => (string) Str::uuid(),
                    ...$item,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // ÉQUIPES
        $teamsData = [
            ['uid' => 'e1','label' => 'Équipe rouge', 'couleur' => '#FF0000'],
            ['uid' => 'e2','label' => 'Équipe bleue', 'couleur' => '#0000FF'],
            ['uid' => 'e3','label' => 'Équipe verte', 'couleur' => '#008000'],
            ['uid' => 'e4','label' => 'Équipe jaune', 'couleur' => '#FFFF00'],
        ];

        $teams = [];

        foreach ($teamsData as $teamData) {
            $teams[] = Team::updateOrCreate(
                ['uid' => $teamData['uid']],
                [
                    'label' => $teamData['label'],
                    'couleur' => $teamData['couleur'],
                ]
            );
        }

        // ADMINISTRATEUR
        User::updateOrCreate(
            ['email' => 'nathan.denut@gmail.com'],
            [
                'nom' => 'Admin',
                'password' => Hash::make('1234'),
            ]
        );

        // UTILISATEURS DE TEST
        $firstNames = [
            'Lucas', 'Emma', 'Nathan', 'Léo', 'Chloé',
            'Hugo', 'Manon', 'Louis', 'Jules', 'Lina',
            'Gabriel', 'Alice', 'Noah', 'Inès', 'Tom',
            'Jade', 'Ethan', 'Sarah', 'Mathis', 'Lola',
        ];

        foreach ($firstNames as $index => $firstName) {
            $team = $teams[$index % count($teams)];

            $user = User::updateOrCreate(
                ['email' => Str::slug($firstName) . '@test.fr'],
                [
                    'nom' => $firstName,
                    'password' => Hash::make('1234'),
                    'team_uid' => $team->uid,
                ]
            );

            // POINTS TÉLÉTHON
            if (!$user->pointsTelethon()->exists()) {
                $numberOfPoints = rand(1, 4);

                for ($i = 0; $i < $numberOfPoints; $i++) {
                    points_telethon::create([
                        'user_uid' => $user->uid,
                        'nb_points' => rand(10, 100),
                        'justificatif' => collect([
                            'Vente de crêpes',
                            'Vente de gaufres',
                            'Vente de bonbons',
                            'Participation à une animation',
                            'Don pour le Téléthon',
                        ])->random(),
                    ]);
                }
            }
        }
    }
}
