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
        Schema::create('avancees', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->foreignId('projet_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('description_md');
            $table->string('slug')->index();
            $table->foreignId('entite_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->binary('image')->nullable()->default(null);
            $table->binary('pdf')->nullable()->default(null);
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
        Schema::dropIfExists('avancees');
    }
};
