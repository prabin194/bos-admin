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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->string('order_id')->unique();
            $table->float('amount');
            $table->string('location');
            $table->text('memo')->nullable();
            $table->enum('status', ['Pending', 'Amount Paid', 'Planted', 'Rejected'])->default('Pending');
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
        Schema::dropIfExists('orders');
    }
};
