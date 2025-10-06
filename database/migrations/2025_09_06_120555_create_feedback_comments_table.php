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
        Schema::create('feedback_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');   // The user who gave feedback
            $table->unsignedBigInteger('report_id'); // The incident report linked to this feedback
            $table->text('comment');                 // Feedback text
            $table->timestamps();

            // Foreign key: user who gave feedback
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // Foreign key: the report being commented on
            $table->foreign('report_id')
                  ->references('id')
                  ->on('incident_report_users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_comments');
    }
};
