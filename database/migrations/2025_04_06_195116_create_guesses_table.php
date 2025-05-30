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
        Schema::create('guesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_session_id');
            $table->unsignedBigInteger('song_id');
            $table->string('guessed_title')->nullable();
            $table->string('guessed_artist')->nullable();
            $table->string('guessed_album')->nullable();
            $table->integer('guessed_year')->nullable();
            $table->integer('points_awarded')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guesses');
    }
};
