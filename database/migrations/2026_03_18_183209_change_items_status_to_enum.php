<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Change to varchar first so string update works
        Schema::table('items', function (Blueprint $table) {
            $table->string('status', 20)->default('active')->change();
        });

        // Step 2: Migrate existing boolean values to string equivalents
        DB::statement("UPDATE items SET status = CASE WHEN status = '1' THEN 'active' ELSE 'inactive' END WHERE status IN ('0', '1')");

        // Step 3: Change to proper enum
        Schema::table('items', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'used'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('status', 20)->default('active')->change();
        });

        DB::statement("UPDATE items SET status = CASE WHEN status IN ('active', 'used') THEN '1' ELSE '0' END");

        Schema::table('items', function (Blueprint $table) {
            $table->boolean('status')->default(true)->change();
        });
    }
};
