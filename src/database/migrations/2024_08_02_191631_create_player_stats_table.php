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
        Schema::create('player_stats', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedTinyInteger('player_id');
            $table->unsignedTinyInteger('assisted_player_id')->nullable();
            $table->unsignedSmallInteger('score');

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('assisted_player_id')->references('id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_stats');
    }
};
