<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delete_requests', function (Blueprint $table) {
            $table->id();

            // Who is requesting the delete
            $table->unsignedBigInteger('user_id');

            // Which report they're requesting to delete
            $table->unsignedBigInteger('delete_report_id');
            $table->string('user_name');
            // Snapshot of the report at the time of request
            $table->string('report_title');
            $table->date('report_date');
            $table->string('report_type');
            $table->text('report_description');

            // Optional image paths (stored as JSON array)
            $table->json('requested_image')
                ->nullable();

            // Reason given by the user
            $table->text('reason')
                ->nullable();

            // Status: pending / accepted / rejected
            $table->enum('status', ['pending', 'accepted', 'rejected'])
                ->default('pending');

            // Timestamps
            $table->timestamp('requested_at')
                ->nullable(); // When user submitted
            $table->timestamp('reviewed_at')
                ->nullable();  // When staff responded

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('delete_report_id')->references('id')
                ->on('incident_report_users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delete_requests');
    }
};
