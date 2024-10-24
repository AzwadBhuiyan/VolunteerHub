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
        Schema::table('volunteers', function (Blueprint $table) {
            $table->boolean('allow_follow')->default(true);
        });
    }
    
    public function down()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn('allow_follow');
        });
    }
};
