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
        Schema::create('cities', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 255)->nullable();
            $table->unsignedMediumInteger('state_id')->nullable()->index();
            $table->string('state_code', 255)->nullable();
            $table->unsignedMediumInteger('country_id')->nullable()->index();
            $table->char('country_code', 2)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->unsignedBigInteger('search_count')->default(0);
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('created_at')->default('2013-12-31 17:01:01');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('cities');
    }
};
