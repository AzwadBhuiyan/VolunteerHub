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
        Schema::table('activities', function (Blueprint $table) {
            $table->text('accomplished_description')->nullable();
            $table->integer('duration')->nullable();
            $table->string('difficulty')->nullable();
            $table->integer('points')->default(0);
        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['accomplished_description', 'duration', 'difficulty', 'points']);
        });
    }
};
