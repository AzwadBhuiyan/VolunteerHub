<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->string('userid')->primary();
            $table->string('org_name');
            $table->text('primary_address');
            $table->text('secondary_address');
            $table->string('website');
            $table->string('org_mobile');
            $table->string('org_telephone');
            $table->text('description')->nullable();
            $table->enum('verification_status', ['unverified', 'verified'])->default('unverified');
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};