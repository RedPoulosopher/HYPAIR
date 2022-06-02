<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entites', function (Blueprint $table) {
            $table->id();
            $table->string('uid',128)->unique(); //ce qui est dans le LDAP
	        $table->string('nom',128);
            $table->string('ratachement');
            $table->string('type', 20);
            $table->text('description_courte', 300)->nullable()->default(null);
            $table->text('description_md')->nullable()->default(null);
            $table->boolean('privee')->default(0); //pour que les listes puissent se cacher
            $table->boolean('ouvert')->default(1); //pour les listes, les bureaux, le téléthon 
            $table->year('annee_creation')->nullable()->default(null);
            $table->year('annee_fin')->nullable()->default(null);
            $table->string('couleur_claire',10)->nullable()->default(null);
            $table->string('couleur_sombre',10)->nullable()->default(null);
            $table->string('couleur_police_accentuation_claire',10)->nullable()->default(null);
            $table->string('couleur_police_accentuation_sombre',10)->nullable()->default(null);
            $table->string('courriel')->nullable()->default(null); //pour la DISI
            $table->string('alias')->nullable()->default(null); //pour la DISI
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entites');
    }
}
