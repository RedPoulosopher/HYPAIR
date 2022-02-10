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
            $table->string('uid',128)->unique();
	        $table->string('nom',128)->unique();
            $table->string('bureau_de_ratachement')->nullable()->default(null);
            $table->string('site')->default('douai');
            $table->string('email')->nullable()->default(null);
            $table->string('alias')->nullable()->default(null);
            $table->boolean('public')->default(1); //pour les listes
            $table->boolean('ouvert')->default(1); //pour les listes, les bureaux, le téléthon
            $table->year('annee_creation')->nullable()->default(null);
            $table->year('annee_fin')->nullable()->default(null);
            $table->text('description');
            $table->string('type', 20);
            $table->string('couleur_claire');
            $table->string('couleur_sombre');
            $table->boolean('accueil_perso')->default(0);
            $table->boolean('menu_perso')->default(0);
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
