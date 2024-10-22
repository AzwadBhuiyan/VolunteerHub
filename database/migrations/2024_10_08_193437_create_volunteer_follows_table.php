<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('volunteer_follows', function (Blueprint $table) {
            $table->id();
            $table->string('follower_id');
            $table->string('followed_id');
            $table->string('type');
            $table->timestamps();
        
            $table->foreign('follower_id')->references('userid')->on('volunteers')->onDelete('cascade');
            $table->index(['followed_id', 'type']);
        
            $table->unique(['follower_id', 'followed_id', 'type'], 'vol_follows_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_follows');
    }
};
