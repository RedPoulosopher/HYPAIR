<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documentations')->insert([
            [
                'association_id' => 1,
                'langue' => 'fr',
                'confidentialite' => 0,
                'titre' => "coucou",
                'slug' => "coucou",
                'description' => "doc pour préciser le contenu",
                'contenu_md' => "# ceci est une doc\n>et on espere que ça marche bien",
                'categories' => '["reseau","test","tech"]',
                'mise_en_avant' => 0,
                'debut_mise_en_avant' => '2020-08-17',
                'fin_mise_en_avant' => '2020-09-12',
            ],
            [
                'association_id' => 1,
                'langue' => 'fr',
                'confidentialite' => 5,
                'titre' => "coucou privé",
                'slug' => "coucou-prive",
                'description' => "doc pour préciser le contenu",
                'contenu_md' => "# ceci est une doc\n>et on espere que ça marche bien",
                'categories' => '["reseau","test","tech"]',
                'mise_en_avant' => 0,
                'debut_mise_en_avant' => '2020-08-17',
                'fin_mise_en_avant' => '2020-09-12',
            ],
            [
                'association_id' => 1,
                'langue' => 'en',
                'confidentialite' => 5,
                'titre' => "content",
                'slug' => "content",
                'description' => "doc for the content",
                'contenu' => "# cthis is a doc and we hope that it is working",
                'categories' => '["network","test","tech"]',
                'mise_en_avant' => 0,
                'debut_mise_en_avant' => '2020-08-17',
                'fin_mise_en_avant' => '2020-09-12',
            ],
            [
                'association_id' => 2,
                'langue' => 'fr',
                'confidentialite' => 0,
                'titre' => "coucou-bde",
                'slug' => "coucou-bde",
                'description' => "doc pour préciser le contenu",
                'contenu' => "# ceci est une doc\n>et on espere que ça marche bien",
                'categories' => '["reseau","test","tech"]',
                'mise_en_avant' => 0,
                'debut_mise_en_avant' => '2020-08-17',
                'fin_mise_en_avant' => '2020-09-12',
            ],
        ]);
    }
}