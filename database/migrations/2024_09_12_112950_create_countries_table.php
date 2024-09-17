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
        Schema::create('countries', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 100);
            $table->char('iso3', 3)->nullable();
            $table->char('numeric_code', 3)->nullable();
            $table->char('code', 2)->nullable();
            $table->unsignedBigInteger('search_count')->default(0);
            $table->string('phonecode', 255)->nullable();
            $table->string('capital', 255)->nullable();
            $table->string('currency', 255)->nullable();
            $table->string('currency_name', 255)->nullable();
            $table->string('currency_symbol', 255)->nullable();
            $table->string('tld', 255)->nullable();
            $table->string('native', 255)->nullable();
            $table->string('region', 255)->nullable();
            $table->unsignedMediumInteger('region_id')->nullable()->index();
            $table->string('subregion', 255)->nullable();
            $table->unsignedMediumInteger('subregion_id')->nullable()->index();
            $table->string('nationality', 255)->nullable();
            $table->text('timezones')->nullable();
            $table->text('translations')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('emoji', 191)->nullable();
            $table->string('emojiU', 191)->nullable();
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
        Schema::dropIfExists('countries');
    }
};
