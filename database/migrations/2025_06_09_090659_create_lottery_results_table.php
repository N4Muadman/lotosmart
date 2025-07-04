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
        Schema::create('lottery_results', function (Blueprint $table) {
            $table->id();
            $table->string('region');
            $table->date('draw_date');
            $table->json('special_prize')->nullable();
            $table->json('first_prize')->nullable();
            $table->json('second_prize')->nullable();
            $table->json('third_prize')->nullable();
            $table->json('fourth_prize')->nullable();
            $table->json('fifth_prize')->nullable();
            $table->json('sixth_prize')->nullable();
            $table->json('seventh_prize')->nullable();
            $table->json('eighth_prize')->nullable();
            $table->json('special_code')->nullable();
            $table->string('province')->nullable();
            $table->timestamps();

            $table->unique(['region', 'draw_date', 'province']);
            $table->index(['region', 'draw_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lottery_results');
    }
};
