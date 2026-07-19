<?php

namespace Database\Seeders;

use App\Models\Entite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EntiteSeeder extends Seeder
{
    public function run(): void
    {
        $entite = Entite::create([
            'uid' => 'air',
            'name' => 'AIR Bureau_test',
            'type' => 'bureau',
            'visible' => true,
        ]);

        DB::table('entites_perms')->insert([
            'entite_uid' => $entite->uid,
            'perm' => 0,
        ]);

        // 1. Récupérer un utilisateur
        $user = DB::table('users')->where('email', 'nathan.denut@gmail.com')->first();

        // 3. Créer le rôle "prez"
        $roleUid = Str::uuid();

        DB::table('roles_list')->insert([
            'uid' => $roleUid,
            'name' => 'prez',
            'pole_uid' => null,
            'ordre' => 0,
            'create_by' => null,
        ]);

        // 4. Assigner le rôle à l'utilisateur
        DB::table('roles')->insert([
            'entite_uid' => $entite->uid,
            'user_uid' => $user->uid,
            'role_uid' => $roleUid,
            'ordre' => 0,
        ]);

        DB::table('perm_role_list')->insert([
            'role_uid' => $roleUid,
            'perm' => 0
        ]);
    }
}