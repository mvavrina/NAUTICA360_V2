<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('api_yacht_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yacht_id');
            $table->string('name')->nullable();
            $table->boolean('crewedByDefault')->nullable();
            $table->boolean('isDefaultProduct')->nullable();
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
        Schema::dropIfExists('api_yacht_products');
    }
};
