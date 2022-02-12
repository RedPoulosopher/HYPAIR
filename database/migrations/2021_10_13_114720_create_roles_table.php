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
	        $table->string('label',128)->unique();
            $table->tinyInteger('niveau_admin')->unsigned()->default(0);
            $table->boolean('gerer_ticket'); // Màj du 12/02/2022
            $table->boolean('gerer_projet');
            $table->boolean('gerer_evenement');
            $table->boolean('gerer_actualite');
            $table->boolean('gerer_documentation');
            $table->boolean('gerer_membre');
            $table->boolean('gerer_association');
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
        Schema::dropIfExists('roles');
    }
}
