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
	        $table->foreignId('association_id')->constrained();
            $table->string('titre');
            $table->string('slug',128)->unique();
            $table->text('description');
            $table->datetime('temps_debut');
            $table->datetime('temps_fin');
            $table->text('lieu');
            $table->integer('max_participation')->nullable()->default(null);
            $table->tinyInteger('confidentialite')->default(0);
            $table->boolean('pour_cotisant')->default(0);
            $table->boolean('important')->default(0);
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
        Schema::dropIfExists('events');
    }
}
