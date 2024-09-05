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
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('estimated_hours')->nullable();
            $table->integer('progress')->default(0);
            $table->enum('priority', ['urgent','very_high','high','medium','low'])->default('medium');
            $table->enum('status', ['open','in_progress','on_hold','cancel','completed','waiting'])->default('open');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
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
