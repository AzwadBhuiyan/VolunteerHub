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
        Schema::create('volunteer_favorite_categories', function (Blueprint $table) {
            $table->string('userid');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
    
            $table->foreign('userid')->references('userid')->on('volunteers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('activity_categories')->onDelete('cascade');
    
            $table->primary(['userid', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_favorite_categories');
    }
};
