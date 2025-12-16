<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Add polymorphic columns if they don't exist already
            if (!Schema::hasColumn('notifications', 'notifiable_type')) {
                $table->string('notifiable_type')->index()->after('type');
            }
            if (!Schema::hasColumn('notifications', 'notifiable_id')) {
                $table->string('notifiable_id')->index()->after('notifiable_type');
            }
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Remove columns if rolling back
            if (Schema::hasColumn('notifications', 'notifiable_type')) {
                $table->dropColumn('notifiable_type');
            }
            if (Schema::hasColumn('notifications', 'notifiable_id')) {
                $table->dropColumn('notifiable_id');
            }
        });
    }
};
