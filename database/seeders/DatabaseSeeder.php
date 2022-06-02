<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(EntitesTableSeeder::class);
        $this->call(DocumentationTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(MembresTableSeeder::class);
        $this->call(SitesSeeder::class);
        $this->call(EntiteSitesSeeder::class);
    }
}
