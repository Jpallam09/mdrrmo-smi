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
        if (!Schema::hasTable('staff_locations')) {
            Schema::create('staff_locations', function (Blueprint $table) {
                $table->id();

                // Staff user who is being tracked
                $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');

                // Link to the incident report being tracked
                $table->foreignId('report_id')->constrained('incident_report_users')->onDelete('cascade');

                // Current latitude and longitude
                $table->decimal('latitude', 10, 7);
                $table->decimal('longitude', 10, 7);

                $table->timestamps();
            });
        }
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_locations');
    }
};
