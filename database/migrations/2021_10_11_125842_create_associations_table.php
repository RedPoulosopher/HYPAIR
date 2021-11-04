<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
	        $table->string('nom',128)->unique();
	        $table->string('slug',128)->unique();
            $table->string('bureau_de_ratachement',9)->nullable()->default(null);
            $table->boolean('est_bureau')->default(0);
            $table->string('site')->default('douai');
            $table->string('email')->nullable()->default(null);
            $table->boolean('public')->default(1); //pour les listes
            $table->year('annee_creation')->nullable()->default(null);
            $table->year('annee_fin')->nullable()->default(null);
            $table->text('description');
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
        Schema::dropIfExists('associations');
    }
}
