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
            // Add a new column
            $table->string('date_ordered')->change()->default(date('Y-m-d H:i:s'))->nullable();
            $table->string('date_claimed')->change()->default(null)->nullable();
            $table->string('date_paid')->change()->default(null)->nullable();
            $table->string('total_price')->change()->default('0')->nullable();
            $table->string('status')->change()->default('pending')->nullable();
        });

        Schema::table('order_items', function (Blueprint $table) {
            // Add a new column
            $table->string('status')->change()->default('pending')->nullable();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            // Add a new column
            $table->string('status')->change()->default('pending')->nullable();
        });

        Schema::table('payments', function (Blueprint $table) {
            // Add a new column
            $table->string('date_paid')->change()->default(date('Y-m-d H:i:s'))->nullable();
            $table->string('total_price')->change()->default('0')->nullable();
            $table->string('status')->change()->default('pending')->nullable();
            $table->string('method')->change()->default('')->nullable();
            $table->string('reference_number')->change()->default('')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
