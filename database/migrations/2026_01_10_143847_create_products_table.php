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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(false);
            $table->foreignId('section_id')->nullable()->references('id')->on('sections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('parent_id')->nullable()->references('id')->on('sections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('merchant_id')->references('id')->on('merchants')->onDelete('cascade')->onUpdate('cascade');
            // Stock & Price
            $table->integer('quantity')->nullable();
            $table->boolean('in_stock')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
