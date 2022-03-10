<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('participations')->insert([
            [
                'evenement_id' => 1,
                'user_id' => 1,
                'status' => '["pas sur","certain","interesse"]',
                'date_maj' => '2021-12-31 11:00:00',
            ]
        ]);
    }
}