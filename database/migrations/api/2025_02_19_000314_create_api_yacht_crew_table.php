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
        Schema::create('api_yacht_crews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yacht_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('age')->nullable();
            $table->string('nationality')->nullable();
            $table->string('roles')->nullable();
            $table->text('licenses')->nullable();
            $table->text('languages')->nullable();
            $table->text('images')->nullable();
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
        Schema::dropIfExists('api_yacht_crew');
    }
};
