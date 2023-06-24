<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news');
            $table->foreignId('topic_id')->constrained();
            $table->timestamps();

            $table->unique(['news_id', 'topic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_topics');
    }
};
