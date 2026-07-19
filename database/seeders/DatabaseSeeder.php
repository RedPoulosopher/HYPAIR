<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'nom' => 'Admin',
            'email' => 'nathan.denut@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        $this->call([
            ConstantesSeeder::class,
            EntiteSeeder::class,
        ]);
    }
}
