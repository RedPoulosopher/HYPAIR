<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uid',191)->unique();
            $table->string('password',191);
            $table->string('nom');
            $table->string('prenom');
            $table->string('langue_pref', 9)->default("fr");
            $table->text('troncho')->nullable();
            $table->tinyInteger('photo')->default(2); //2=>aucune; 0=>identicone; 1=>photo
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
