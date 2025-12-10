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
        Schema::create('travel_group_invitations', function (Blueprint $table) {
            $table->id();

            // Which travel group this invite belongs to
            $table->foreignId('travel_group_id')
                  ->constrained('travel_groups')
                  ->onDelete('cascade');

            // Email of the invited person
            $table->string('email');

            // Who sent the invitation
            $table->foreignId('invited_by')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Invitation status: pending, accepted, declined
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_group_invitations');
    }
};
