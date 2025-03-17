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
        Schema::create('api_yachts', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            //$table->string('external_id')->unique(); // ID from API
            $table->string('name')->nullable();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('modelId')->nullable();
            $table->bigInteger('shipyardId')->nullable();
            $table->integer('year')->nullable();
            $table->string('kind')->nullable();
            $table->string('certificate')->nullable();
            $table->unsignedBigInteger('homeBaseId')->nullable();
            $table->string('homeBase')->nullable();
            $table->unsignedBigInteger('companyId')->nullable();
            $table->string('company')->nullable();
            $table->float('draught')->nullable();
            $table->float('beam')->nullable();
            $table->float('length')->nullable();
            $table->float('waterCapacity')->nullable();
            $table->float('fuelCapacity')->nullable();
            $table->string('engine')->nullable();
            $table->float('deposit')->nullable();
            $table->float('depositWithWaiver')->nullable(); // added
            $table->string('currency')->nullable();
            $table->float('commissionPercentage')->nullable();
            $table->float('maxDiscountFromCommissionPercentage')->nullable(); // added
            $table->integer('wc')->nullable();
            $table->integer('berths')->nullable();
            $table->integer('cabins')->nullable();
            $table->text('wcNote')->nullable();
            $table->text('berthsNote')->nullable();
            $table->text('cabinsNote')->nullable();
            $table->float('transitLog')->nullable();
            $table->float('mainsailArea')->nullable();
            $table->float('genoaArea')->nullable();
            $table->string('mainsailType')->nullable();
            $table->string('genoaType')->nullable();
            $table->boolean('requiredSkipperLicense')->nullable();
            $table->integer('defaultCheckInDay')->nullable();
            $table->json('allCheckInDays')->nullable(); // added
            $table->string('defaultCheckInTime')->nullable();
            $table->string('defaultCheckOutTime')->nullable();
            $table->integer('minimumCharterDuration')->nullable();
            $table->integer('maximumCharterDuration')->nullable(); // added maxCharterDuration from API
            $table->integer('maxPeopleOnBoard')->nullable();
            $table->text('comment')->nullable(); // added comment
            $table->timestamps();
            
            $table->index(['modelId', 'homeBaseId', 'companyId']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_yachts');
    }
};
