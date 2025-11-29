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
        Schema::create('productdata', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('productName');
            $table->decimal('productPrice', 10, 2);
            $table->text('productDesc')->nullable();
            $table->string('productImage');
            $table->boolean('bestseller')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productdata');
    }
};
