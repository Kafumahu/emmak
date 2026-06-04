<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->timestamps();
        });

        // Table pivot article_tag
        Schema::create('article_tag', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['article_id', 'tag_id']);
        });

        // Table pivot commentaire_tag
        Schema::create('commentaire_tag', function (Blueprint $table) {
            $table->foreignId('commentaire_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['commentaire_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commentaire_tag');
        Schema::dropIfExists('article_tag');
        Schema::dropIfExists('tags');
    }
};