<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
	        $table->foreignId('entite_id');
            $table->string('titre');
            $table->string('slug',128);
            $table->text('description');
            $table->datetime('temps_debut');
            $table->datetime('temps_fin');
            $table->text('lieu')->nullable();
            $table->integer('max_participation')->nullable()->default(0);
            $table->tinyInteger('confidentialite')->default(0);
            $table->boolean('pour_cotisant')->default(0);
            $table->boolean('important')->default(0);
            $table->boolean('validation')->default(0);
            $table->unsignedBigInteger('derive_de')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('evenements', function (Blueprint $table) {
            $table->foreign('derive_de')->references('id')->on('evenements')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evenements');
    }
}
