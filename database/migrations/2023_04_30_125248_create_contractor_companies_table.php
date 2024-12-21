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
        Schema::create('contractor_companies', function (Blueprint $table) {
            $table->id();
            $table->string('contractor_id');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('license_number')->nullable();
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_companies');
    }
};
