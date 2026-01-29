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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('type'); // UI, API, FE
            $table->string('status')->default('todo'); // todo, doing, done
            $table->string('assignee')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable(); // Link to Figma/Jira
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
