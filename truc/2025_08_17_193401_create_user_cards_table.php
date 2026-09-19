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
        Schema::create('user_cards', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->unsignedBigInteger('uid_card');
            $table->string('uid_user');
            $table->string('uid_admin');
            $table->timestamps();

            $table->foreign('uid_card')->references('id')->on('card_models')->onDelete('cascade');
            $table->foreign('uid_user')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('uid_admin')->references('uid')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_cards');
    }
};
