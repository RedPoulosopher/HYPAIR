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
	        $table->string('langue')->default("fr");
	        $table->integer('ID_asso');
            $table->tinyInteger('confidentialite')->default(0);
            $table->string('titre',128);
            $table->string('slug',128);
            $table->text('contenu');
            $table->json('categories')->nullable();
            $table->boolean('mise_en_avant')->default(0);
            $table->date('debut_mise_en_avant')->nullable()->default(null);
            $table->date('fin_mise_en_avant')->nullable()->default(null);
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
        Schema::dropIfExists('documentations');
    }
}
