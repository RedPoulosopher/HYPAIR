<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentations', function (Blueprint $table) {
            $table->id();
	        $table->foreignId('association_id')->constrained();
	        $table->string('langue')->default("fr");
            $table->tinyInteger('confidentialite')->unsigned()->default(0);
            $table->string('titre',128);
            $table->string('slug',128)->unique();
            $table->text('description'); //courte description pour le moteur de recherche
            $table->text('contenu_md');
            $table->json('categories')->nullable();
            $table->tinyInteger('visible')->default(0); // 0 => affichée dans l'index 1 => recherchable mais pas affichée dans l'index 2 => ni recherchable ni affichée dans l'index (pratique pour compléter d'autres documentations)
            $table->boolean('mise_en_avant')->default(0); //possible affichage sur la page d'accueil
            $table->date('debut_mise_en_avant')->nullable()->default(null); //possible affichage automatique sur la page d'accueil
            $table->date('fin_mise_en_avant')->nullable()->default(null); //possible affichage automatique sur la page d'accueil
            $table->unsignedBigInteger('derive_de')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('documentations', function (Blueprint $table) {
            $table->foreign('derive_de')->references('id')->on('documentations')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentations');
    }
}
