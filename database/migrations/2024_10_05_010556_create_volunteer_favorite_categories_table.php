<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerFavoriteCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_favorite_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->references('userid')->on('volunteers')->onDelete('cascade');
            $table->foreignId('category_id')->references('id')->on('activity_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteer_favorite_categories');
    }
}