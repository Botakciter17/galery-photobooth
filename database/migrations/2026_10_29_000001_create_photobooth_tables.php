<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('photo_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('session_code')->index();
            $table->string('slug', 32)->unique();
            $table->string('user_email')->nullable();
            $table->timestamps();
        });

        Schema::create('session_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_session_id')->constrained('photo_sessions')->cascadeOnDelete();
            $table->string('type'); // 'strip' or 'single'
            $table->string('file_path');
            $table->string('original_filename');
            $table->unsignedSmallInteger('photo_index')->default(0);
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_photos');
        Schema::dropIfExists('photo_sessions');
        Schema::dropIfExists('events');
    }
};
