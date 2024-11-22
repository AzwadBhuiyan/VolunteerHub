<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_requests', function (Blueprint $table) {
            $table->id();
            $table->string('volunteer_userid');
            $table->string('approved_by')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('district');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('volunteer_userid')
                  ->references('userid')
                  ->on('volunteers')
                  ->onDelete('cascade');

            $table->foreign('approved_by')
                  ->references('userid')
                  ->on('organizations')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_requests');
    }
};