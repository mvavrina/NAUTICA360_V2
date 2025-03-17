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
        Schema::create('api_yacht_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yacht_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->integer('sortOrder')->nullable();
            $table->boolean('image_generated')->default(false);
            
            $table->timestamps();
            $table->foreign('yacht_id')->references('id')->on('api_yachts')->onDelete('cascade');

            $table->index(['yacht_id', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_yacht_images');
    }
};
