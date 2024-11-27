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
            $table->boolean('dont_show_again')->default(false);
            $table->integer('last_step_seen')->default(0);
            $table->timestamps();

            $table->foreign('userid')->references('userid')->on('volunteers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutorial_progress');
    }
};