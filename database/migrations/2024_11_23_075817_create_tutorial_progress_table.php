<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tutorial_progress', function (Blueprint $table) {
            $table->id();
            $table->string('userid');
            $table->string('page_name');
            $table->boolean('completed')->default(false);
            $table->boolean('dont_show_again')->default(false);
            $table->integer('last_step_seen')->default(0);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            
            // Composite unique index
            $table->unique(['userid', 'page_name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutorial_progress');
    }
};