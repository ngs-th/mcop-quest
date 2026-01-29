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
        Schema::create('flows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('system_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('group')->nullable(); // For separating squads if needed
            $table->string('assignee')->nullable(); // Main owner
            
            // The 6 HP Bars (0-100%)
            $table->integer('hp_design')->default(0);
            $table->integer('hp_ac')->default(0);
            $table->integer('hp_api')->default(0);
            $table->integer('hp_fe')->default(0);
            $table->integer('hp_testing')->default(0);
            $table->integer('hp_uat')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flows');
    }
};
