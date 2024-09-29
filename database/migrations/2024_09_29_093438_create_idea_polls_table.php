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
        Schema::create('idea_polls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idea_thread_id');
            $table->string('question');
            $table->timestamps();
    
            $table->foreign('idea_thread_id')->references('id')->on('idea_threads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idea_polls');
    }
};
