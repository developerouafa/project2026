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
        Schema::create('color_variants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Light Red, Dark Red
            $table->string('code')->nullable();
            $table->foreignId('product_color_id')->constrained('product_colors')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_variants');
    }
};
