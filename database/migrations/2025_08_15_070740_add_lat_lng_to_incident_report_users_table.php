<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('incident_report_users', function (Blueprint $table) {
            if (!Schema::hasColumn('incident_report_users', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable();
            }
            if (!Schema::hasColumn('incident_report_users', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable();
            }
            if (!Schema::hasColumn('incident_report_users', 'barangay')) {
                $table->string('barangay')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('incident_report_users', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
