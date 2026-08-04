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
        Schema::table('orders', function (Blueprint $table) {
            // Payment method snapshot (values, not a relation)
            $table->unsignedBigInteger('payment_method_id')->nullable()->after('shipping_price');
            $table->string('payment_method_code')->nullable()->after('payment_method_id');
            $table->string('payment_method_name')->nullable()->after('payment_method_code');
            $table->string('payment_method_image')->nullable()->after('payment_method_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method_id', 'payment_method_code', 'payment_method_name', 'payment_method_image']);
        });
    }
};
