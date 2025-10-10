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
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->timestamp('payment_date')->useCurrent();
            $table->decimal('amount', 12, 2);
            $table->enum('payment_method', ['cash','bank_transfer','ewallet'])->default('cash');
            $table->enum('payment_status', ['unpaid','pending','paid','failed','refunded'])->default('unpaid');
            $table->string('transaction_reference')->nullable();
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
