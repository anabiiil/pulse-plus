<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Validity window (inclusive by day). Null means "no bound" on that side.
     */
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->date('starts_at')->nullable()->after('value');
            $table->date('expires_at')->nullable()->after('starts_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['starts_at', 'expires_at']);
        });
    }
};
