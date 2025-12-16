<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained() // references `id` on `users`
                ->cascadeOnDelete();

            $table->enum('app', ['incident_reporting', 'document_request']);
            $table->enum('role', ['user', 'staff', 'admin']);
            $table->timestamps();

            $table->unique(['user_id', 'app']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
