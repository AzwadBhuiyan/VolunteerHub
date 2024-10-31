<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idea_poll_id')->constrained('idea_polls')->onDelete('cascade');
            $table->foreignId('poll_option_id')->constrained('poll_options')->onDelete('cascade');
            $table->string('user_id');
            $table->timestamps();

            $table->unique(['idea_poll_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('poll_votes');
    }
};