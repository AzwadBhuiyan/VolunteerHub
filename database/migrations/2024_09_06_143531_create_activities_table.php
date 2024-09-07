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
        Schema::create('activities', function (Blueprint $table) {
            $table->id('activityid');
            $table->string('userid');
            $table->string('title');
            $table->text('description');
            $table->date('date');
            $table->time('time');
            $table->string('category');
            $table->string('district');
            $table->text('address');
            $table->dateTime('deadline');
            $table->integer('min_volunteers');
            $table->integer('max_volunteers')->nullable();
            $table->enum('status', ['open', 'closed', 'cancelled', 'completed'])->default('open');
            $table->timestamps();
        
            $table->foreign('userid')->references('userid')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
