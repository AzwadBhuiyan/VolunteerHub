<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_requests', function (Blueprint $table) {
            $table->foreignId('activity_id')->nullable();
            $table->string('status')->default('pending')->change(); // Modify existing status column
        });
    }

    public function down(): void
    {
        Schema::table('activity_requests', function (Blueprint $table) {
            $table->dropColumn('activity_id');
            $table->string('status')->default('pending')->change();
        });
    }
};