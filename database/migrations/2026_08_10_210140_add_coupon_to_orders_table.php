<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Coupon values are stored as SNAPSHOTS on the order (code + discount amount)
     * so an order keeps its applied discount even if the coupon changes later.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id')->nullable()->after('user_id');
            $table->string('coupon_code')->nullable()->after('coupon_id');
            $table->decimal('discount', 10, 2)->default(0)->after('subtotal');

            $table->index('coupon_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['coupon_id']);
            $table->dropColumn(['coupon_id', 'coupon_code', 'discount']);
        });
    }
};
