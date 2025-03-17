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
        Schema::create('api_yacht_descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yacht_id');
            $table->string('category')->nullable();
            $table->text('text')->nullable();
            $table->longText('documents')->nullable();
            $table->timestamps();

            $table->foreign('yacht_id')->references('id')->on('api_yachts')->onDelete('cascade');

            $table->index(['yacht_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_yacht_descriptions');
    }
};
