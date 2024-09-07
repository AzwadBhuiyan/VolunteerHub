<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activity_volunteers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activityid');
            $table->string('volunteer_userid');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('activityid')->references('activityid')->on('activities')->onDelete('cascade');
            $table->foreign('volunteer_userid')->references('userid')->on('volunteers')->onDelete('cascade');

            $table->unique(['activityid', 'volunteer_userid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_volunteers');
    }
};
