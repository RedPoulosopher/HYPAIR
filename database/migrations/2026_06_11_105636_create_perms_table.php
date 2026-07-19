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
        Schema::create('poles_list', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('name');
            $table->integer('ordre')->default(0);
            $table->foreignUuid('create_by')->nullable()->constrained('entites', 'uid')->onDelete('cascade');
        });
        Schema::create('roles_list', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('name');
            $table->foreignUuid('pole_uid')->nullable()->constrained('poles_list', 'uid')->onDelete('cascade');
            $table->integer('ordre')->default(0);
            $table->foreignUuid('create_by')->nullable()->constrained('entites', 'uid')->onDelete('cascade');
        });
        Schema::create('perm_role_list', function (Blueprint $table) {
            $table->uuid('role_uid')->constrained('roles_list', 'uid')->onDelete('cascade');
            $table->integer('perm');
            $table->primary(['role_uid','perm']);
        });
        Schema::create('entites_perms', function (Blueprint $table) {
            $table->foreignUuid('entite_uid')->constrained('entites', 'uid')->onDelete('cascade');
            $table->integer('perm');
            $table->primary(['entite_uid','perm']);
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->foreignUuid('entite_uid')->constrained('entites', 'uid')->onDelete('cascade');
            $table->foreignUuid('user_uid')->constrained('users', 'uid')->onDelete('cascade');
            $table->foreignUuid('role_uid')->constrained('roles_list', 'uid')->onDelete('cascade');
            $table->integer('ordre')->default(0);
            $table->primary(['entite_uid','user_uid','role_uid']);
        });
        Schema::create('user_perms', function (Blueprint $table) {
            $table->foreignUuid('entite_uid')->constrained('entites', 'uid')->onDelete('cascade');
            $table->foreignUuid('user_uid')->constrained('users', 'uid')->onDelete('cascade');
            $table->integer('perm');
            $table->string('add_or_remove');
            $table->timestamps();
            $table->primary(['entite_uid','user_uid','perm']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_perms');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('entites_perms');
        Schema::dropIfExists('perm_role_list');
        Schema::dropIfExists('roles_list');
        Schema::dropIfExists('poles_list');
    }
};
