<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('travel_preferences', function (Blueprint $table) {
            $table->id();

            // which user this preference belongs to
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('travel_group_id');
            

            // simple text fields
            $table->string('travel_style')->nullable();        // e.g. budget, luxury
            $table->string('budget_level')->nullable();        // low / medium / high
            $table->json('preferred_activities')->nullable();  // hiking, museums, etc.
            $table->json('preferred_countries')->nullable();   // Italy, Japan, ...
            $table->text('notes')->nullable();

            $table->timestamps();

            // foreign key
            $table->foreign('travel_group_id')
                  ->references('id')->on('travel_groups')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('travel_preferences');
    }
};
