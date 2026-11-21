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
        Schema::create('item_ventes', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('label');
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('label');
            $table->string('couleur');
            $table->timestamps();
        });

        Schema::create('points_telethon', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignUuid('user_uid')->constrained('users', 'uid')->onDelete('cascade');
            $table->integer('nb_points');
            $table->string('justificatif');
            $table->timestamps();
        });

        Schema::create('user_team', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignUuid('user_uid')->constrained('users', 'uid')->onDelete('cascade');
            $table->foreignUuid('team_uid')->constrained('teams', 'uid')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_team');
        Schema::dropIfExists('points_telethon');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('item_ventes');
    }
};
