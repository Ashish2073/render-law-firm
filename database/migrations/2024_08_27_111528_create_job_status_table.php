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
        Schema::create('job_status', function (Blueprint $table) {
            $table->id();
            $table->string('job_id'); // Add job_id column
            $table->string('job_name');
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->unsignedBigInteger('push_notification_id');
            $table->foreign('push_notification_id')->references('id')->on('push_notifications')->onDelete('cascade');
            $table->text('error_message')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
             $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_status');
    }
};
