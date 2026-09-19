<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('card_models', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->id();
            $table->string("entity_name");
            $table->string("subtitle");
            $table->string("uid_entite");
            $table->string("logo_img");

            $table->string("text_color_1");
            $table->string("text_color_2");
            $table->string("background_1");
            $table->string("background_2");
            $table->string("background_img");

            $table->boolean("poste");
            $table->string("conditions_expiration");
            $table->date("expiration_date");
            $table->timestamps();

            $table->foreign('uid_entite')->references('uid')->on('entites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_models');
    }
};
