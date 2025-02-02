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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('sender', 255);
            $table->string('receiver', 255);
            $table->text('message');
            $table->integer('read');
            $table->integer('date');
            $table->timestamps();

            $table->foreign('sender')->references('username')->on('users')->cascadeOnDelete();
            $table->foreign('receiver')->references('username')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
