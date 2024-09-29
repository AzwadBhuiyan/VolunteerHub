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
        Schema::create('idea_threads', function (Blueprint $table) {
            $table->id();
            $table->string('userid');
            $table->string('title');
            $table->text('description');
            $table->integer('votes')->default(0);
            $table->timestamps();
    
            $table->foreign('userid')->references('userid')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idea_threads');
    }
};
