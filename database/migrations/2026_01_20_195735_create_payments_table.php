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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);

            $table->enum('method', [
                'cash',
                'stripe'
            ]);

            $table->enum('status', [
                'pending',    // COD default
                'paid',       // online paid (escrow)
                'collected',  // COD collected
                'failed',
                'refunded',
                'cancelled'
            ])->default('pending');
            $table->string('stripe_id')->nullable()->index();
            $table->string('pm_type')->nullable();
            $table->string('pm_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();

            $table->string('reference')->nullable(); // transaction id
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
