<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('edit_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('edit_requests', 'requested_barangay')) {
                $table->string('requested_barangay')->nullable();
            }
            if (!Schema::hasColumn('edit_requests', 'requested_latitude')) {
                $table->decimal('requested_latitude', 10, 7)->nullable();
            }
            if (!Schema::hasColumn('edit_requests', 'requested_longitude')) {
                $table->decimal('requested_longitude', 10, 7)->nullable();
            }
            if (!Schema::hasColumn('edit_requests', 'requested_report_date')) {
                $table->date('requested_report_date')->nullable();
            }
        });
    }


    public function down(): void
    {
        Schema::table('edit_requests', function (Blueprint $table) {
            if (Schema::hasColumn('edit_requests', 'requested_barangay')) {
                $table->dropColumn('requested_barangay');
            }
            if (Schema::hasColumn('edit_requests', 'requested_latitude')) {
                $table->dropColumn('requested_latitude');
            }
            if (Schema::hasColumn('edit_requests', 'requested_longitude')) {
                $table->dropColumn('requested_longitude');
            }
            if (Schema::hasColumn('edit_requests', 'requested_report_date')) {
                $table->dropColumn('requested_report_date');
            }
        });
    }
};
