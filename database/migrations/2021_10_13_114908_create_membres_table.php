<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
	        $table->foreignId('user_id')->constrained();
            $table->foreignId('association_id')->constrained();
	        $table->foreignId('role_id')->constrained();
            $table->date('date_rejoint')->nullable()->useCurrent();
            $table->json('competences')->nullable(); // vérifier l'utilité
            $table->tinyInteger('niveau_admin')->unsigned()->nullable()->default(null); // idem
            $table->timestamps(); // idem
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membres');
    }
}
