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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->string('attachmentable_type');
            $table->string('attachmentable_id');
            $table->index(['attachmentable_type', 'attachmentable_id']);
            $table->string('name');
            $table->string('original_name');
            $table->string('caption')->nullable();
            $table->string('alt')->nullable();
            $table->string('type');
            $table->string('size');
            $table->string('url');
            $table->bigInteger('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
