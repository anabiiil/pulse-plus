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
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->boolean('requires_receipt')->default(false)->after('is_active');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('receipt_url')->nullable()->after('payment_method_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('requires_receipt');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('receipt_url');
        });
    }
};
