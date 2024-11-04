<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('idea_threads', function (Blueprint $table) {
            $table->unsignedBigInteger('winner_comment_id')->nullable();
            $table->foreign('winner_comment_id')->references('id')->on('idea_comments');
        });
    }

    public function down()
    {
        Schema::table('idea_threads', function (Blueprint $table) {
            $table->dropForeign(['winner_comment_id']);
            $table->dropColumn('winner_comment_id');
        });
    }
};