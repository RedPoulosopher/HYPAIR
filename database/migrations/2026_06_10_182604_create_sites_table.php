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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('label');
        });

        Schema::create('user_sites', function (Blueprint $table) {
            $table->foreignUuid('user_uid')->constrained('users', 'uid')->onDelete('cascade');
            $table->foreignId('site_id')->constrained('sites', 'id')->onDelete('cascade');
            $table->primary(['user_uid', 'site_id']);
        });

        Schema::create('entite_sites', function (Blueprint $table) {
            $table->foreignUuid('entite_uid')->constrained('entites', 'uid')->onDelete('cascade');
            $table->foreignId('site_id')->constrained('sites', 'id')->onDelete('cascade');
            $table->primary(['entite_uid', 'site_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entite_sites');
        Schema::dropIfExists('user_sites');
        Schema::dropIfExists('sites');
    }
};
