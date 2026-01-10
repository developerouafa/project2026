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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->decimal('amount', 10, 2)->nullable(); // تخفيض مبلغ ثابت
            $table->decimal('percent', 5, 2)->nullable(); // تخفيض بالنسبة %
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->foreignId('product_color_sizes_id')
                ->nullable()
                ->constrained('product_color_sizes')
                ->cascadeOnDelete();

            $table->foreignId('color_variant_sizes_id')
                ->nullable()
                ->constrained('color_variant_sizes')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
