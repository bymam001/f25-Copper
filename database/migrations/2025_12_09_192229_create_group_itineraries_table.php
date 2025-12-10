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
        Schema::create('group_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_group_id')
                  ->constrained('travel_groups')
                  ->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('generated_by_ai')->default(false);
            $table->enum('status', ['draft', 'pending_approval', 'approved'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_itineraries');
    }
};
