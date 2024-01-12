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
        //On renomme l'attribut 'cle' en 'lien' et on augmente sa longueur
        Schema::table('reseaux_sociaux', function(Blueprint $table)
        {
            $table->string('cle',128)->change();
            $table->renameColumn('cle', 'lien');

            //Correction des fautes
            $table->renameColumn('reseau_sociable_id', 'reseau_social_id');
            $table->renameColumn('reseau_sociable_type', 'reseau_social_type');
        });

        //On regroupe la 'pre_url' et l'ancien attribut 'cle' dans la nouvelle colonne 'lien' de la table réseaux sociaux
        DB::statement('UPDATE `reseaux_sociaux` SET lien = CONCAT((SELECT pre_url FROM `reseaux_sociaux_liste` WHERE id = `reseaux_sociaux`.reseaux_sociaux_liste_id), lien);');    
        
        //On renomme 'pre_url' en 'placeholder'
        Schema::table('reseaux_sociaux_liste', function(Blueprint $table)
        {
            //Distinction du placeholder pour les utilisateurs par rapport à celui des entités
            $table->renameColumn('pre_url', 'placeholder_entite');
            $table->string('placeholder_utilisateur');
        });

        //Par défaut, le placeholder_utilisateur vaudra la même chose que l'utilisateur (modifier sur phpMyAdmin en prod)        
        DB::statement("UPDATE `reseaux_sociaux_liste` SET placeholder_utilisateur = placeholder_entite");

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
