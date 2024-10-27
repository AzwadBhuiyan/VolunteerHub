<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->text('message');
            $table->timestamps();

            $table->foreign('activity_id')
                  ->references('activityid')
                  ->on('activities')
                  ->onDelete('cascade');
        });

        Schema::create('milestone_reads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('milestone_id');
            $table->string('volunteer_userid');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('milestone_id')
                  ->references('id')
                  ->on('activity_milestones')
                  ->onDelete('cascade');
            $table->foreign('volunteer_userid')
                  ->references('userid')
                  ->on('volunteers')
                  ->onDelete('cascade');

            $table->unique(['milestone_id', 'volunteer_userid']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('milestone_reads');
        Schema::dropIfExists('activity_milestones');
    }
};