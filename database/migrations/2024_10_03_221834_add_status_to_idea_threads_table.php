<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('idea_threads', function (Blueprint $table) {
            $table->string('status')->default('open')->after('description');
        });
    }

    public function down()
    {
        Schema::table('idea_threads', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};