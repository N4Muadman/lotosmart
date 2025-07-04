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
        Schema::create('loto_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('region');
            $table->date('draw_date');
            $table->boolean('is_special_prize')->default(false);
            $table->string('province')->nullable();
            $table->string('full_number');
            $table->string('loto_number');
            $table->timestamps();

            // Indexes for performance
            $table->unique(['region', 'draw_date', 'province', 'full_number']);
            $table->index(['region', 'draw_date', 'province']);
            $table->index(['loto_number', 'region']);
            $table->index(['draw_date', 'loto_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loto_numbers');
    }
};
