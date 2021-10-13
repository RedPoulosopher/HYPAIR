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
            $table->text('contenu');
            $table->json('categories')->nullable();
            $table->boolean('mise_en_avant')->default(0); //possible affichage sur la page d'accueil
            $table->date('debut_mise_en_avant')->nullable()->default(null); //possible affichage automatique sur la page d'accueil
            $table->date('fin_mise_en_avant')->nullable()->default(null); //possible affichage automatique sur la page d'accueil
            $table->string('traduction_de',128)->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('documentations', function (Blueprint $table) {
            $table->foreign('traduction_de')->references('slug')->on('documentations')->onUpdate('cascade')->onDelete('cascade');
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
