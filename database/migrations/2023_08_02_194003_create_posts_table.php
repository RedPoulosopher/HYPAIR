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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable();
            $table->string('titre');
            $table->text('description');
            $table->dateTime('date_apparition');
            $table->dateTime('date_expiration')->nullable();
            $table->string('tags')->nullable();
            $table->foreignId('entite_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('event_id')->nullable()->references('id')->on('evenements')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('entite_id')->references('id')->on('entites')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
