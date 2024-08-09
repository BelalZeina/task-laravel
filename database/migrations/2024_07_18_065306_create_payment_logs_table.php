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
        $main_types = [
            'order',
        ];
        Schema::create('payment_logs', function (Blueprint $table)use ($main_types ) {
            $table->id();
            $table->string('bill_no')->nullable();
            $table->nullableMorphs('owner');
            $table->string('currency')->default("SAR");
            $table->double('amount', 20, 4)->default(0);
            $table->enum('type', $main_types);
            $table->boolean('status')->default(false);
            $table->enum('payment_tool', ['visa','bank_transfer']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};
