<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->string('audio_snippet', 1024)->change(); // increase size
        });
    }

    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->string('audio_snippet', 191)->change(); // revert size
        });
    }
};
