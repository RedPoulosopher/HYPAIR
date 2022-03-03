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
            $table->string('association_uid',128)->references('uid')->on('associations')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('confidentialite');
            $table->foreignId('chef_id')->unique();
            $table->string('titre');
            $table->string('uid',128)->unique();
            $table->string('chef_projet')->unique();
            $table->text('description_courte'); 
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
