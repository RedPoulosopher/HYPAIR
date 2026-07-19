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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid('profile_picture')->nullable()->constrained('files_registre', 'uid')->onDelete('set null');
            $table->foreignUuid('id_photo')->nullable()->constrained('files_registre', 'uid')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['profile_picture']);
            $table->dropForeign(['id_photo']);

            $table->dropColumn(['profile_picture', 'id_photo']);
        });
    }
};
