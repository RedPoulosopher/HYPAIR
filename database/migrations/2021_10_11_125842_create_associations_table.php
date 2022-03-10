<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('uid',128)->unique(); //ce qui est dans le LDAP
	        $table->string('nom',128);
            $table->string('bureau_de_ratachement');
            $table->string('type', 20);
            $table->text('description')->nullable()->default(null);
            $table->json('sites')->nullable()->default(null);
            $table->json('categories')->nullable()->default(null);
            $table->boolean('privee')->default(0); //pour que les listes puissent se cacher
            $table->boolean('ouvert')->default(1); //pour les listes, les bureaux, le téléthon 
            $table->year('annee_creation')->nullable()->default(null);
            $table->year('annee_fin')->nullable()->default(null);
            $table->string('couleur_claire')->nullable()->default(null);
            $table->string('couleur_sombre')->nullable()->default(null);
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
        Schema::dropIfExists('associations');
    }
}
