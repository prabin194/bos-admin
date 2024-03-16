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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->float('price');
            $table->foreignUuid('category_id')->nullable();
            $table->foreign('category_id')->references('uid')->on('categories')->onDelete('Set Null');
            $table->foreignUuid('user_id')->nullable();
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('Set Null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
