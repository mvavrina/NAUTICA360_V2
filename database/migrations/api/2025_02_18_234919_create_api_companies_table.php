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
        Schema::create('api_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('zip');
            $table->string('country');
            $table->string('telephone');
            $table->string('telephone2')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('vatCode');
            $table->string('email');
            $table->string('web')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->longtext('termsAndConditions')->nullable();
            $table->longtext('checkoutNote')->nullable();
            $table->float('maxDiscountFromCommissionPercentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_companies');
    }
};
