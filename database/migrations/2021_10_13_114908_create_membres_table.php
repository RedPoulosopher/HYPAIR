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
	        $table->foreignId('associations_id')->constrained();
	        $table->foreignId('users_id')->constrained();
	        $table->foreignId('roles_id')->constrained();
            $table->json('competences')->nullable();
            $table->date('date_rejoint')->nullable()->useCurrent();
            $table->tinyInteger('niveau_admin')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('membres');
    }
}
