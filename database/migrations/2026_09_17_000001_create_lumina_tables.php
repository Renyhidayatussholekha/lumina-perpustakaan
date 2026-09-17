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
        // 1. Houses (Fraksi Sekolah)
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('emblem');
            $table->string('motto');
            $table->string('color_hex');
            $table->integer('total_points')->default(0);
            $table->integer('member_count')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Books
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author');
            $table->string('category');
            $table->string('grade_level')->default('Semua Jenjang');
            $table->text('cover_url');
            $table->text('banner_url')->nullable();
            $table->text('synopsis');
            $table->string('ai_summary_1');
            $table->string('ai_summary_2');
            $table->string('ai_summary_3');
            $table->integer('reading_time_minutes')->default(30);
            $table->decimal('rating', 3, 1)->default(4.8);
            $table->integer('total_readers')->default(120);
            $table->longText('audio_text')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('trending_label')->nullable();
            $table->timestamps();
        });

        // 3. Characters for Roleplay AI
        Schema::create('book_characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('name');
            $table->string('role_title');
            $table->text('avatar');
            $table->text('greeting_message');
            $table->text('system_persona');
            $table->json('sample_questions')->nullable();
            $table->timestamps();
        });

        // 4. Quests (Misi Mingguan)
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('icon');
            $table->integer('target_count')->default(1);
            $table->integer('current_count')->default(0);
            $table->integer('xp_reward')->default(50);
            $table->string('category')->default('reading');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });

        // 5. Badges (Etalase Lencana)
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('icon');
            $table->string('color');
            $table->boolean('unlocked')->default(false);
            $table->string('unlocked_date')->nullable();
            $table->string('category')->default('achievement');
            $table->timestamps();
        });

        // 6. Discussions (Klub Buku Virtual)
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('user_name');
            $table->string('user_avatar');
            $table->string('user_house');
            $table->text('comment');
            $table->boolean('is_ai_prompt')->default(false);
            $table->integer('likes_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('quests');
        Schema::dropIfExists('book_characters');
        Schema::dropIfExists('books');
        Schema::dropIfExists('houses');
    }
};
