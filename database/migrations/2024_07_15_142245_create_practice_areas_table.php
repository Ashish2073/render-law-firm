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
        Schema::create('practice_areas', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->foreignId('parent_id')->constraint('practice_areas')->onDelete('cascade')->nullable();
            $table->foreignId('created_by')->constraint('users')->onDelete('cascade')->nullable();
            $table->integer('updated_by')->constraint('users')->onDelete('cascade')->nullable();
            $table->softDeletes();

             // Manually add created_at and updated_at with default values
    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    
    // Add deleted_at for soft deletes, defaulting to NULL
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_areas');
    }
};
