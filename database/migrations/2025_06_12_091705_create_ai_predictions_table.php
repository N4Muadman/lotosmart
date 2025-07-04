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
        Schema::create('ai_predictions', function (Blueprint $table) {
            $table->id();
            $table->string('region', 10);
            $table->string('province')->nullable();
            $table->date('prediction_date');
            $table->enum('prediction_type', ['so_de', 'so_lo']);
            $table->json('numbers');
            $table->timestamps();
            
            $table->unique(['prediction_date', 'region', 'prediction_type', 'province'], 'date_region_type_unique');
            $table->index(['prediction_date', 'region']);
            $table->index(['prediction_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_predictions');
    }
};
