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
        Schema::create('card_regions', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->longText('text');
            $table->boolean('show_hp')->default(true);
            $table->string('img')->nullable(); 
            $table->string('flag')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_regions');
    }
};
