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
        Schema::create('defects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['defects', 'enhancement'])->default('defects');
            $table->enum('priority', ['urgent','very_high','high','medium','low'])->default('medium');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->string('estimated_hours')->nullable();
            $table->enum('status', ['assigned','open','in_progress','solved','closed','reopen','deferred'])->default('open');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('assigned_to_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defects');
    }
};
