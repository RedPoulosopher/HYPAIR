<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('association_id')->references('id')->on('associations')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('confidentialite');
            $table->string('titre');
            $table->string('slug')->index();
            $table->foreignId('chef_projet')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description_courte');
            $table->date('date_fin');
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
        Schema::dropIfExists('projets');
    }
}
