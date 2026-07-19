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
        Schema::create('entites', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('name');
            $table->foreignUuid('parent_uid')->nullable()->constrained('entites', 'uid')->onDelete('set null');
            $table->string('type');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->year('founded_year')->nullable();
            $table->boolean('visible')->default(true);
            $table->string('color_1')->nullable();
            $table->string('color_2')->nullable();
            $table->string('email')->nullable();
            $table->string('alias')->nullable();
            $table->string('tags')->nullable()->default("");
            $table->integer("display_ordre")->default(0);
            $table->foreignUuid('logo')->nullable()->constrained('files_registre', 'uid')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entites');
    }
};
