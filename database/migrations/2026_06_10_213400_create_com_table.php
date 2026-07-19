<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignUuid('entite_uid')->constrained('entites', 'uid')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignUuid('banner_uid')->nullable()->constrained('files_registre', 'uid')->onDelete('set null');
            $table->string('lieu')->nullable()->default("");
            $table->dateTime('published_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->string('validation_status')->nullable();
            $table->unsignedInteger('max_participants')->nullable();
            $table->boolean('visible_all')->default(true);
            $table->boolean('sub_registrations')->default(false);
            $table->string('tags')->nullable()->default("");
            $table->json('json_data')->default(DB::raw('(JSON_OBJECT())'));
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignUuid('entite_uid')->constrained('entites', 'uid')->onDelete('cascade');
            $table->foreignUuid('event_uid')->nullable()->constrained('events', 'uid')->onDelete('set null');;
            $table->string('title');
            $table->text('content')->nullable();
            $table->foreignUuid('banner_uid')->nullable()->constrained('files_registre', 'uid')->onDelete('set null');
            $table->dateTime('published_at')->nullable();
            $table->dateTime('archived_at')->nullable();
            $table->string('tags')->nullable()->default("");
            $table->json('json_data')->default(DB::raw('(JSON_OBJECT())'));
            $table->timestamps();
        });

        Schema::create('direct_msg', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('title');
            $table->text('content');
            $table->foreignUuid('sender_uid')->nullable()->constrained('users', 'uid')->onDelete('set null');;
            $table->foreignUuid('sender_entite_uid')->nullable()->constrained('entites', 'uid')->onDelete('set null');
            $table->foreignUuid('receiver_uid')->nullable()->constrained('users', 'uid')->onDelete('set null');
            $table->foreignUuid('receiver_entite_uid')->nullable()->constrained('entites', 'uid')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('com_collabs', function (Blueprint $table) {
            $table->uuid('object_uid');
            $table->string('object_type');
            $table->foreignUuid('entite_uid')->constrained('entites', 'uid')->onDelete('cascade');
            $table->primary(['object_uid', 'entite_uid', 'object_type']);
        });

        Schema::create('participants', function (Blueprint $table) {
            $table->foreignUuid('event_uid')->constrained('events', 'uid')->onDelete('cascade');
            $table->foreignUuid('user_uid')->constrained('users', 'uid')->onDelete('cascade');
            $table->foreignUuid('valider_uid')->nullable()->constrained('users', 'uid')->onDelete('set null');
            $table->string('status')->default('pending');
            $table->primary(['event_uid', 'user_uid']);
            
        });

        Schema::create('event_sites', function (Blueprint $table) {
            $table->foreignUuid('event_uid')->constrained('events', 'uid')->onDelete('cascade');
            $table->foreignId('site_id')->constrained('sites', 'id')->onDelete('cascade');
            $table->primary(['event_uid', 'site_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_sites');
        Schema::dropIfExists('participants');
        Schema::dropIfExists('com_collabs');
        Schema::dropIfExists('direct_msg');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('events');
    }
};
