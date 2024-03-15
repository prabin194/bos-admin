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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->foreignUuid('order_id')->nullable();
            $table->foreign('order_id')->references('uid')->on('orders')->onDelete('Set Null');
            $table->foreignUuid('product_id')->nullable();
            $table->foreign('product_id')->references('uid')->on('products')->onDelete('Set Null');
            $table->bigInteger('quantity');
            $table->float('price');
            $table->float('total');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
