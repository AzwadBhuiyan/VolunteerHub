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
        Schema::create('volunteer_follows', function (Blueprint $table) {
            $table->id();
            $table->string('volunteer_userid');
            $table->string('organization_userid');
            $table->timestamps();
    
            $table->foreign('volunteer_userid')->references('userid')->on('volunteers')->onDelete('cascade');
            $table->foreign('organization_userid')->references('userid')->on('organizations')->onDelete('cascade');
    
            $table->unique(['volunteer_userid', 'organization_userid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_follows');
    }
};
