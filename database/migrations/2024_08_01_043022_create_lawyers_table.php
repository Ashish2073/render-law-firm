<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_no')->unique();
            $table->string('password');
            $table->decimal('avg_rating')->comment('Rating value from 1 to 5')->default(0.00);
            $table->enum('status',[0,1])->default(1);
            $table->unsignedInteger('ratings_count')->default(0);
            $table->unsignedInteger('ratings_sum')->default(0);
            $table->string('otp')->nullable();
            $table->tinyInteger('is_verified')->default(0);
            $table->string('otp_created_at')->nullable();
            $table->text('description_bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->timestamp('email_verified_at')->nullable();   
          
            $table->rememberToken();
         
    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    

    $table->timestamp('deleted_at')->nullable(); 

        });

        Schema::create('proficiencies',function(Blueprint $table){
            $table->id();
            $table->string('proficience_name');
             // Manually add created_at and updated_at with default values
    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    
    // Add deleted_at for soft deletes, defaulting to NULL
    $table->timestamp('deleted_at')->nullable(); 
        });


        Schema::create('lawyer_proficiencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lawyer_id');
            $table->foreign('lawyer_id')->references('id')->on('lawyers')->onDelete('cascade');
            $table->unsignedBigInteger('proficience_id');
            $table->foreign('proficience_id')->references('id')->on('proficiencies')->onDelete('cascade');
             // Manually add created_at and updated_at with default values
    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    
    // Add deleted_at for soft deletes, defaulting to NULL
    $table->timestamp('deleted_at')->nullable(); 
            $table->unique(['lawyer_id', 'proficience_id']);
        });

        Schema::create('lawyer_ratings',function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('lawyer_id');
            $table->foreign('lawyer_id')->references('id')->on('lawyers')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->comment('Rating value from 1 to 5');
           $table->string('review')->nullable()->comment('Optional review text');
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
        Schema::dropIfExists('lawyers');
        Schema::dropIfExists('lawyer_ratings');
        Schema::dropIfExists('lawyer_ratings');
        Schema::dropIfExists('proficiencies');
    }
};
