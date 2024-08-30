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
        Schema::create('public_favorite_movies', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('movie_id');
            $table->timestamps();
            $table->unique(['username', 'movie_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_favorite_movies');
    }
};
