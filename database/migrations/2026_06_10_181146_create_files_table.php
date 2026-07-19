<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files_registre', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('filename');
            $table->string('path');
            $table->string('extension');
            $table->string('disk');
            $table->unsignedBigInteger('size');
            $table->json('json_data')->default(DB::raw('(JSON_OBJECT())'));
            $table->timestamps();
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->uuid('attachable_id');
            $table->string('attachable_type');
            $table->uuid('attachment_id');
            $table->string('attachment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('files_registre');
    }
};
