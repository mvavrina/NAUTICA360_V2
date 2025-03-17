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
        Schema::create('api_yacht_extras', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('yacht_id');
            $table->string('name')->nullable();
            $table->boolean('obligatory')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('unit')->nullable();
            $table->boolean('payableInBase')->nullable();
            $table->boolean('includesDepositWaiver')->default(false);
            $table->integer('validDaysFrom')->nullable();
            $table->integer('validDaysTo')->nullable();
            $table->dateTime('validDateFrom')->nullable();
            $table->dateTime('validDateTo')->nullable();
            $table->dateTime('sailingDateFrom')->nullable();
            $table->dateTime('sailingDateTo')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('availableInBase')->nullable();
            $table->timestamps();
            
            // Add validSailingAreas as a JSON column
            $table->json('validSailingAreas')->nullable();
        
            $table->foreign('yacht_id')->references('id')->on('api_yachts')->onDelete('cascade');

            $table->index(['yacht_id', 'id', 'availableInBase']);
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_yacht_extras');
    }
};
