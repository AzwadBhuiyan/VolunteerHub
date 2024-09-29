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
            $table->unsignedBigInteger('idea_thread_id');
            $table->string('user_userid');
            $table->tinyInteger('vote'); // 1 for upvote, -1 for downvote
            $table->timestamps();
    
            $table->foreign('idea_thread_id')->references('id')->on('idea_threads')->onDelete('cascade');
            $table->foreign('user_userid')->references('userid')->on('users')->onDelete('cascade');
            $table->unique(['idea_thread_id', 'user_userid']);
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
