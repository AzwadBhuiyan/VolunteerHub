<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activity_volunteers', function (Blueprint $table) {
            $table->boolean('visibility')->default(true)->after('approval_status');
        });
    }

    public function down()
    {
        Schema::table('activity_volunteers', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
};