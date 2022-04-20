<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseaux_sociaux_liste', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('couleur',10);
            $table->string('pre_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reseaux_sociaux_liste');
    }
};
