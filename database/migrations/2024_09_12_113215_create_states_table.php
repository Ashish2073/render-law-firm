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
       
           Schema::create('states', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 255);
            $table->unsignedMediumInteger('country_id')->index();
            $table->char('country_code', 2);
            $table->string('fips_code', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->unsignedBigInteger('search_count')->default(0);
            $table->string('type', 191)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->tinyInteger('flag')->default(1);
            $table->string('wikiDataId', 255)->nullable();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
