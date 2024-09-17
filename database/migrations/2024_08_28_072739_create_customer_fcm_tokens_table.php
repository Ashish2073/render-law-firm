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
        Schema::create('customer_fcm_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('fcm_token');
            $table->string('fcm_type');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unique(['fcm_token','customer_id']);
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
        Schema::dropIfExists('customer_fcm_tokens');
    }
};
