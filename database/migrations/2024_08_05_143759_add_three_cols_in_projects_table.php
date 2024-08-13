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
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable()->after('client_id');
            $table->enum('billing_type', ['hourly', 'fixed'])->nullable()->after('description');
            $table->boolean('is_auto_progress')->default(0)->after('budget');

            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['team_id', 'billing_type', 'is_auto_progress']);
        });
    }
};
