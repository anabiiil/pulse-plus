<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * All shipping/pricing values are stored as SNAPSHOTS (plain columns), not
     * relations, so an order keeps its original values even if a product or a
     * governorate price changes later.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Customer / shipping snapshot
            $table->string('customer_name');
            $table->string('customer_phone', 30);
            $table->unsignedBigInteger('governorate_id')->nullable(); // reference only, no FK
            $table->string('governorate_name');
            $table->text('address');
            $table->string('shipping_method')->default('governorate_delivery');
            $table->decimal('shipping_price', 10, 2)->default(0);

            // Money snapshot
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->string('status')->default('pending');
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
