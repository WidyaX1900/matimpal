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
        Schema::create('video_calls', function (Blueprint $table) {
            $table->id();
            $table->string('main_user', 255);
            $table->string('main_role', 255);
            $table->string('secondary_user', 255);
            $table->string('secondary_role', 255);
            $table->string('room', 255);
            $table->string('status', 255);
            $table->string('peer_id', 1000);
            $table->string('camera', 255);
            $table->string('audio', 255);
            $table->string('direction', 255);
            $table->integer('date_start');
            $table->integer('date_end');
            $table->timestamps();

            $table->foreign('main_user')->references('username')->on('users')->cascadeOnDelete();
            $table->foreign('secondary_user')->references('username')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_calls');
    }
};
