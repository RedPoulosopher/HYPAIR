<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Spécifier l'encodage pour une colonne si elle peut avoir des emojis ()
        DB::statement('ALTER TABLE `posts` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL');
        DB::statement('ALTER TABLE `posts` CHANGE `titre` `titre` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL');
        DB::statement('ALTER TABLE `evenements` CHANGE `titre` `titre` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
