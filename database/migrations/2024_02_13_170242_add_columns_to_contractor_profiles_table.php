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
        Schema::table('contractor_profiles', function (Blueprint $table) {
            // Add marketsharp_contractor column with enum values 0 and 1, defaulting to 0
            $table->enum('marketsharp_contractor', [0, 1])->default(0)->after('status');

            // Add lead_capture_code column as text, nullable
            $table->text('lead_capture_code')->nullable()->after('marketsharp_contractor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contractor_profiles', function (Blueprint $table) {
            // Reverse the changes made in the 'up' method
            $table->dropColumn('marketsharp_contractor');
            $table->dropColumn('lead_capture_code');
        });
    }
};
