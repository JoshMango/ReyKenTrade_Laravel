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
        Schema::create('orderdata', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('user_id')->constrained('userdata', 'user_id')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_mode');
            $table->string('refNumber')->nullable();
            $table->text('shipping_address');
            $table->string('customer_number');
            $table->timestamp('order_date');
            $table->string('order_status')->default('Undelivered');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderdata');
    }
};
