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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('google_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('otp')->nullable();
            $table->string('otp_created_at')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('password');
            $table->string('fcm_token')->nullable();
            $table->string('verification_token')->nullable();
            $table->tinyInteger('is_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

             // Manually add created_at and updated_at with default values
    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    
    // Add deleted_at for soft deletes, defaulting to NULL
    $table->timestamp('deleted_at')->nullable(); 
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
      
    }
};
