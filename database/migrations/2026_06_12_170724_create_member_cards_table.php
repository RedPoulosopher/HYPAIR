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
        Schema::create('votes', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('name');
            $table->foreignUuid('entity_uid')->constrained('entites', 'uid')->onDelete('cascade');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();
        });

        Schema::create('vote_options', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignUuid('vote_uid')->constrained('votes', 'uid')->onDelete('cascade');
            $table->string('option');
            $table->foreignUuid('image')->nullable()->constrained('files_registre', 'uid')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('vote_user', function (Blueprint $table) {
            $table->foreignUuid('vote_uid')->constrained('votes', 'uid')->onDelete('cascade');
            $table->foreignUuid('user_uid')->constrained('users', 'uid');
            $table->foreignUuid('option_uid')->constrained('vote_options', 'uid')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('cards_model', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('title');
            $table->text('subtitle');
            $table->foreignUuid('logo')->nullable()->constrained('files_registre', 'uid')->onDelete('set null');
            $table->string('color_1')->nullable();
            $table->string('color_2')->nullable();
            $table->string('font_color_1')->nullable();
            $table->string('font_color_2')->nullable();
            $table->foreignUuid('background')->nullable()->constrained('files_registre', 'uid')->onDelete('set null');
            $table->json('expirate_condition')->nullable();
            $table->timestamps();
        });

        Schema::create('member_cards', function (Blueprint $table) {
            $table->foreignUuid('card_model_uid')->nullable()->constrained('cards_model', 'uid')->onDelete('set null');
            $table->foreignUuid('user_uid')->nullable()->constrained('users', 'uid')->onDelete('cascade');
            $table->foreignUuid('added_by')->nullable()->constrained('users', 'uid')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_cards');
        Schema::dropIfExists('cards_model');
        Schema::dropIfExists('vote_user');
        Schema::dropIfExists('vote_options');
        Schema::dropIfExists('votes');
    }
};
