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
        Schema::create('idea_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idea_thread_id')->nullable();
            $table->unsignedBigInteger('idea_comment_id')->nullable();
            $table->string('user_userid');
            $table->tinyInteger('vote'); // 1 for upvote, -1 for downvote
            $table->timestamps();
    
            $table->foreign('idea_thread_id')->references('id')->on('idea_threads')->onDelete('cascade');
            $table->foreign('idea_comment_id')->references('id')->on('idea_comments')->onDelete('cascade');
            $table->foreign('user_userid')->references('userid')->on('users')->onDelete('cascade');
            
            // Ensure a user can only vote once per thread or comment
            $table->unique(['idea_thread_id', 'idea_comment_id', 'user_userid'], 'idea_vote_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idea_votes');
    }
};