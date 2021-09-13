<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentation', function (Blueprint $table) {
            $table->id();
	        $table->integer('ID_asso');
            $table->tinyInteger('confidentialite')->default(0);
            $table->string('titre',128);
            $table->text('contenu');
            $table->boolean('mise_en_avant');
            $table->date('debut_mise_en_avant');
            $table->date('fin_mise_en_avant');
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
        Schema::dropIfExists('documentation');
    }
}
