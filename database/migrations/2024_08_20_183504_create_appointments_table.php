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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['reserved', 'confirmed', 'finished', 'cancel'])->default('reserved');
            $table->timestamps();

            $table->foreign('organizer_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
