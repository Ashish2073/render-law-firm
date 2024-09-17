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
        Schema::table('lawyer_proficiencies', function (Blueprint $table) {
            $table->unique(['lawyer_id', 'proficience_id'],'unique_lawyer_proficiencie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyer_proficiencies', function (Blueprint $table) {
            $table->dropUnique('unique_lawyer_proficiencie');
        });
    }
};
