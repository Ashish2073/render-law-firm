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


        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('case_type');
            $table->foreign('case_type')->references('id')->on('proficiencies')->onDelete('cascade');
            
            
            $table->unsignedBigInteger('assign_lawyer_id')->nullable();
            $table->foreign('assign_lawyer_id')->references('id')->on('lawyers')->onDelete('cascade');
        
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');


            $table->unsignedBigInteger('case_user_id')->nullable();
            $table->foreign('case_user_id')->references('id')->on('case_users')->onDelete('cascade');


            $table->unsignedBigInteger('preferred_attroney_id')->nullable();;
            $table->foreign('preferred_attroney_id')->references('id')->on('lawyers')->onDelete('cascade');
         
           
           
            $table->enum('case_urgency_level',[1,2,3,4])->nullable();
            $table->text('requirement_details')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable(); 
        });

        Schema::create('case_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('messenger_id');
           
            $table->string('guard');
            $table->unsignedBigInteger('cases_id');
            $table->foreign('cases_id')->references('id')->on('cases')->onDelete('cascade');
            $table->enum('lawyer_message_status',[0,1])->default(0);
            $table->enum('customer_message_status',[0,1])->default(0);
            $table->enum('user_message_status',[0,1])->default(0);
            $table->text('message');
            
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
        Schema::dropIfExists('messages');
      
    }
};
