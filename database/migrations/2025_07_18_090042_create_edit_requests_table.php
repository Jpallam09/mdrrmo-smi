<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('edit_requests', function (Blueprint $table) {
            $table->id();

            // Who is requesting the delete
            $table->unsignedBigInteger('user_id');
            // Foreign keys
            $table->foreignId('edit_report_id')
                ->constrained('incident_report_users')
                ->onDelete('cascade');
            $table->string('user_name');
            // Add this under requested_by
            $table->foreignId('reviewed_by')
                ->nullable()->constrained('users')
                ->onDelete('set null');

            $table->text('reason')->nullable();

            // Fields that may be changed
            $table->string('requested_title', 150)->nullable();
            $table->text('requested_description')->nullable();
            $table->enum('requested_type', ['Safety', 'Security', 'Operational', 'Environmental'])->nullable();
            $table->date('requested_report_date')->nullable(); // Add report date
            $table->string('requested_barangay')->nullable(); // Add barangay
            $table->decimal('requested_latitude', 10, 7)->nullable(); // Add latitude
            $table->decimal('requested_longitude', 10, 7)->nullable(); // Add longitude
            $table->json('requested_image')->nullable();

            // Request tracking
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edit_requests');
    }
};
