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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->string('userid')->primary();
            $table->string('Name');
            $table->string('Phone');
            $table->string('NID')->nullable();
            $table->enum('Gender', ['M', 'F', 'O']);
            $table->date('DOB');
            $table->string('BloodGroup');
            $table->text('PresentAddress');
            $table->text('PermanentAddress');
            $table->enum('District', [
                'Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 'Sylhet', 'Rangpur', 'Mymensingh', 'Comilla', 
                'Narayanganj', 'Gazipur', 'Faridpur', 'Gopalganj', 'Kishoreganj', 'Madaripur', 'Manikganj', 'Munshiganj', 
                'Narsingdi', 'Rajbari', 'Shariatpur', 'Tangail', 'Brahmanbaria', 'Chandpur', 'Coxs Bazar', 'Feni', 
                'Khagrachari', 'Lakshmipur', 'Noakhali', 'Rangamati', 'Bandarban', 'Bagerhat', 'Chuadanga', 'Jashore', 
                'Jhenaidah', 'Kushtia', 'Magura', 'Meherpur', 'Narail', 'Satkhira', 'Barguna', 'Bhola', 'Jhalokathi', 
                'Patuakhali', 'Pirojpur', 'Bogra', 'Jaipurhat', 'Naogaon', 'Natore', 'Nawabganj', 'Pabna', 'Sirajganj', 
                'Dinajpur', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Nilphamari', 'Panchagarh', 'Thakurgaon', 'Habiganj', 
                'Maulvibazar', 'Sunamganj', 'Jamalpur', 'Netrokona', 'Sherpur'
            ]);
            $table->boolean('TrainedInEmergencyResponse')->default(false);
            $table->integer('Points')->default(0);
            $table->json('Badges')->nullable();
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
