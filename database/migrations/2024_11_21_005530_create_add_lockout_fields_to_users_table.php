<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->integer('max_attempts')->default(5);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_attempts', 'locked_until', 'max_attempts']);
        });
    }
};