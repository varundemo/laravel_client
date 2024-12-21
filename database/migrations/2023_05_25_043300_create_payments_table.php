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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('contractor_id');
            $table->string('payment_id');
            $table->decimal('amount', 10, 2); 
            $table->string('captured');
            $table->string('currency');
            $table->string('paid');
            $table->string('payment_method')->nullable();
            $table->string('card_type')->nullable();
            $table->string('receipt_url')->nullable();
            $table->string("status");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
