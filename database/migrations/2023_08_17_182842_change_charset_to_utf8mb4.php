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
        Schema::table('avancees', function (Blueprint $table) {
            $table->string('titre', 255)->charset('utf8mb4')->change();
            $table->string('titre', 255)->collation('utf8mb4_bin')->change();
            $table->text('description_md')->charset('utf8mb4')->change();
            $table->string('description_md')->collation('utf8mb4_bin')->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('label', 255)->charset('utf8mb4')->change();
            $table->string('label', 255)->collation('utf8mb4_bin')->change();
        });

        Schema::table('documentations', function (Blueprint $table) {
            $table->string('titre', 128)->charset('utf8mb4')->change();
            $table->string('titre', 128)->collation('utf8mb4_bin')->change();
            $table->text('description')->charset('utf8mb4')->change();
            $table->text('description')->collation('utf8mb4_bin')->change();
            $table->text('contenu_md')->charset('utf8mb4')->change();
            $table->text('contenu_md')->collation('utf8mb4_bin')->change();
            $table->text('categories')->charset('utf8mb4')->change();
            $table->text('categories')->collation('utf8mb4_bin')->change();
        });

        Schema::table('entites', function (Blueprint $table) {
            $table->string('nom', 128)->charset('utf8mb4')->change();
            $table->string('nom', 128)->collation('utf8mb4_bin')->change();
            $table->text('description_courte')->charset('utf8mb4')->change();
            $table->string('description_courte')->collation('utf8mb4_bin')->change();
            $table->text('description_md')->charset('utf8mb4')->change();
            $table->string('description_md')->collation('utf8mb4_bin')->change();
        });

        Schema::table('evenements', function (Blueprint $table) {
            $table->string('titre', 255)->charset('utf8mb4')->change();
            $table->string('titre', 255)->collation('utf8mb4_bin')->change();
            $table->text('description')->charset('utf8mb4')->change();
            $table->string('description')->collation('utf8mb4_bin')->change();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('titre', 255)->charset('utf8mb4')->change();
            $table->string('titre', 255)->collation('utf8mb4_bin')->change();
            $table->text('description')->charset('utf8mb4')->change();
            $table->string('description')->collation('utf8mb4_bin')->change();
        });

        Schema::table('projets', function (Blueprint $table) {
            $table->string('titre', 255)->charset('utf8mb4')->change();
            $table->string('titre', 255)->collation('utf8mb4_bin')->change();
            $table->text('description_courte')->charset('utf8mb4')->change();
            $table->string('description_courte')->collation('utf8mb4_bin')->change();
        });

        Schema::table('reseaux_sociaux_liste', function (Blueprint $table) {
            $table->string('nom', 255)->charset('utf8mb4')->change();
            $table->string('nom', 255)->collation('utf8mb4_bin')->change();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->string('label', 128)->charset('utf8mb4')->change();
            $table->string('label', 128)->collation('utf8mb4_bin')->change();
        });

        Schema::table('sites', function (Blueprint $table) {
            $table->string('label', 255)->charset('utf8mb4')->change();
            $table->string('label', 255)->collation('utf8mb4_bin')->change();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->string('name', 25)->charset('utf8mb4')->change();
            $table->string('name', 25)->collation('utf8mb4_bin')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('nom', 255)->charset('utf8mb4')->change();
            $table->string('nom', 255)->collation('utf8mb4_bin')->change();
            $table->string('prenom', 255)->charset('utf8mb4')->change();
            $table->string('prenom', 255)->collation('utf8mb4_bin')->change();
            $table->string('pronom', 20)->charset('utf8mb4')->change();
            $table->string('pronom', 20)->collation('utf8mb4_bin')->change();
            $table->string('bio', 400)->charset('utf8mb4')->change();
            $table->string('bio', 400)->collation('utf8mb4_bin')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
