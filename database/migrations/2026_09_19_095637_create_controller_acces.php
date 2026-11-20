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
        Schema::create('controller_acces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('token')->unique();
            $table->timestamps();
        });

        Schema::create('logs_acces', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('user_uid')
                ->nullable()
                ->constrained('users', 'uid');

            $table->foreignId('controller_id')
                ->constrained('controller_acces')
                ->onDelete('cascade');

            $table->string('uid_carte_etu');

            $table->timestamps();
        });

        Schema::create('entite_acces', function (Blueprint $table) {
            $table->foreignId('controller_id')
                ->constrained('controller_acces')
                ->onDelete('cascade');

            $table->foreignUuid('entite_uid')
                ->constrained('entites', 'uid')
                ->onDelete('cascade');

            $table->unique(['controller_id', 'entite_uid']);
        });

        Schema::create('user_acces', function (Blueprint $table) {
            $table->foreignId('controller_id')
                ->constrained('controller_acces')
                ->onDelete('cascade');

            $table->foreignUuid('entite_uid')
                ->constrained('entites', 'uid')
                ->onDelete('cascade');

            $table->foreignUuid('user_uid')
                ->constrained('users', 'uid')
                ->onDelete('cascade');

            $table->foreignUuid('add_by_user')
                ->nullable()
                ->constrained('users', 'uid')
                ->onDelete('set null');

            $table->timestamps();

            $table->unique(['controller_id', 'entite_uid', 'user_uid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_acces');
        Schema::dropIfExists('entite_acces');
        Schema::dropIfExists('logs_acces');
        Schema::dropIfExists('controller_acces');
    }
};
