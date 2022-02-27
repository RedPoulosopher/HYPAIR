<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
	        $table->string('label',128);
            $table->tinyInteger('niveau_admin')->unsigned()->default(0);
            $table->boolean('gerer_actualite')->default(0);
            $table->boolean('gerer_association')->default(0);
            $table->boolean('gerer_documentation')->default(0);
            $table->boolean('gerer_evenement')->default(0);
            $table->boolean('gerer_membre')->default(0);
            $table->boolean('gerer_projet')->default(0);
            $table->boolean('gerer_ticket')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
