<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert(
            [
                [
                    'id' => 1,
                    'event_id' => 1,
                    'titre' => 'mon super post',
                    'description' => 'ceci est ma description géniale',
                    'date_apparition' => '2022-04-12 08:00:00',
                    'date_expiration' => '2022-04-17 08:00:00',
                    'entite_id' => 1
                ],
                [
                    'id' => 2,
                    'event_id' => 3,
                    'titre' => 'un post éclatax',
                    'description' => 'ceci est ma description pas si ouf que ça en fait...',
                    'date_apparition' => '2022-06-12 08:00:00',
                    'date_expiration' => '2022-06-17 08:00:00',
                    'entite_id' => 1
                ],
                [
                    'id' => 3,
                    'event_id' => null,
                    'titre' => 'ma grosse actu',
                    'description' => "ceci est ma description géniale d'une actu encore mieux",
                    'date_apparition' => '2022-04-12 15:00:00',
                    'date_expiration' => '2022-04-22 20:00:00',
                    'entite_id' => 3
                ],
                [
                    'id' => 4,
                    'event_id' => 4,
                    'titre' => 'un bon gros post sa mère',
                    'description' => "Abréviation : bpsm !",
                    'date_apparition' => '2022-04-12 15:00:00',
                    'date_expiration' => '2022-04-22 20:00:00',
                    'entite_id' => 5
                ],
            ]
        );
    }
}
