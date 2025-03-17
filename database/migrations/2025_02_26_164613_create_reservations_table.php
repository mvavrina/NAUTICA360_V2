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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('tel');
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->dateTime('reserved');
            $table->foreignId('yacht_id')->constrained('api_yachts')->onDelete('cascade');
            $table->double('price');
            $table->double('discount');
            $table->double('base_price');
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
