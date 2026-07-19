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
        Schema::create('groups', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('name');
            $table->string('type');
            $table->integer('level')->default(0);
            $table->foreignUuid('create_by')->nullable()->constrained('entites', 'uid')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->foreignUuid('group_uid')->constrained('groups', 'uid')->onDelete('cascade');
            $table->foreignUuid('user_uid')->constrained('users', 'uid')->onDelete('cascade');
        });

        Schema::create('com_conditions', function (Blueprint $table) {
            $table->uuid('object_id');
            $table->string('object_type');
            $table->uuid('condition_id');
            $table->string('condition_type');
            $table->boolean('notify')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('com_conditions');
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('groups');
    }
};
