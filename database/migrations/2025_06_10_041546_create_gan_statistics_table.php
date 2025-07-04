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
        Schema::create('gan_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('region', 10);
            $table->enum('type', ['Đề', 'Lô']);
            $table->date('calculation_date');
            $table->json('gan_days');
            $table->timestamp('last_draw_date');
            $table->timestamps();
            
            $table->unique(['region', 'calculation_date']);
            $table->index(['region', 'calculation_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gan_statistics');
    }
};
