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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('project')->nullable();
            $table->string('service')->nullable();
            $table->string('service_location')->nullable();
            $table->text('appraisals_detail')->nullable();
            $table->string('state')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('zip');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
