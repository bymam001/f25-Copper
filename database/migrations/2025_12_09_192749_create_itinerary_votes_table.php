<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('itinerary_votes')) {
            Schema::create('itinerary_votes', function (Blueprint $table) {
                $table->id();

                $table->foreignId('itinerary_id')
                      ->constrained('group_itineraries')
                      ->onDelete('cascade');

                $table->foreignId('user_id')
                      ->constrained('users')
                      ->onDelete('cascade');

                $table->enum('vote', ['approve', 'reject']);
                $table->text('comment')->nullable();

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('itinerary_votes');
    }
};
