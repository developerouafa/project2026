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
        Schema::create('color_variant_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('color_variant_id')
                ->constrained('color_variants')
                ->cascadeOnDelete();
            $table->foreignId('size_id')
                ->constrained('sizes')
                ->cascadeOnDelete();


            $table->integer('quantity')->default(0);
            $table->decimal('price', 10, 2);
            $table->boolean('in_stock')->default(true);

            $table->string('sku')->nullable();
            $table->timestamps();
            $table->unique(['color_variant_id', 'size_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_variant_sizes');
    }
};
