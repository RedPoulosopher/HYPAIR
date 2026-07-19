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
        Schema::create('reseaux_sociaux', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('color')->nullable();
            $table->string('font_color')->nullable();
            $table->string('placeholder_entite')->nullable();
            $table->string('placeholder_user')->nullable();
        });

        Schema::create('entite_reseaux_sociaux', function (Blueprint $table) {
            $table->foreignUuid('entite_uid')->constrained('entites', 'uid')->onDelete('cascade');
            $table->foreignId('reseau_social_id')->constrained('reseaux_sociaux', 'id')->onDelete('cascade');
            $table->string('url');
            $table->primary(['entite_uid', 'reseau_social_id']);
        });

        Schema::create('user_reseaux_sociaux', function (Blueprint $table) {
            $table->foreignUuid('user_uid')->constrained('users', 'uid')->onDelete('cascade');
            $table->foreignId('reseau_social_id')->constrained('reseaux_sociaux', 'id')->onDelete('cascade');
            $table->string('url');
            $table->primary(['user_uid', 'reseau_social_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reseaux_sociaux');
        Schema::dropIfExists('entite_reseaux_sociaux');
        Schema::dropIfExists('reseaux_sociaux');
    }
};
