<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags_posts')->insert(
            [
                [
                    'post_id' => 1,
                    'tag_id' => 6,
                ],
                [
                    'post_id' => 1,
                    'tag_id' => 3,
                ],
                [
                    'post_id' => 2,
                    'tag_id' => 1,
                ],
                [
                    'post_id' => 3,
                    'tag_id' => 3,
                ],
                [
                    'post_id' => 3,
                    'tag_id' => 7,
                ],
                [
                    'post_id' => 4,
                    'tag_id' => 6,
                ],
                [
                    'post_id' => 5,
                    'tag_id' => 2,
                ],
                [
                    'post_id' => 5,
                    'tag_id' => 5,
                ],
            ]
        );
    }
}
