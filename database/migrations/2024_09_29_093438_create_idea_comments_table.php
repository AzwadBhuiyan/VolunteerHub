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
        Schema::create('idea_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idea_thread_id');
            $table->string('volunteer_userid');
            $table->string('comment', 200);
            $table->timestamps();
    
            $table->foreign('idea_thread_id')->references('id')->on('idea_threads')->onDelete('cascade');
            $table->foreign('volunteer_userid')->references('userid')->on('volunteers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idea_comments');
    }
};
