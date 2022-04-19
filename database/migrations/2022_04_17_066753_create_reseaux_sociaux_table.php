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
        Schema::create('reseaux_sociaux', function (Blueprint $table) {
            $table->id();
	        $table->bigInteger('reseau_sociable_id');
            $table->string('reseau_sociable_type');
	        $table->foreignId('reseaux_sociaux_liste_id')->constrained('reseaux_sociaux_liste')->onUpdate('cascade')->onDelete('cascade');
            $table->string('cle',128);
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
        Schema::dropIfExists('reseaux_sociaux');
    }
};
