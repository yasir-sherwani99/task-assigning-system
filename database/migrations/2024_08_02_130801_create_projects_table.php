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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('version')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->string('demo_url')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->string('estimated_hours')->nullable();
            $table->decimal('budget', 10,2)->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['open','in_progress','on_hold','cancel','completed'])->default('open');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('assigned_to_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
