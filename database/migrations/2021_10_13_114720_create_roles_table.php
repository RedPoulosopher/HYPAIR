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
            $table->boolean('gerer_ticket')->default(false); // Màj du 13/02/2022
            $table->boolean('gerer_projet')->default(false);
            $table->boolean('gerer_evenement')->default(false);
            $table->boolean('gerer_actualite')->default(false);
            $table->boolean('gerer_documentation')->default(false);
            $table->boolean('gerer_membre')->default(false);
            $table->boolean('gerer_association')->default(false);
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
