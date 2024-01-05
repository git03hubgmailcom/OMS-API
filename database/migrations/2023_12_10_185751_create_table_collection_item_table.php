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
        Schema::create('table_collection_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained('collections'); // foreign key
            $table->foreignId('order_id')->constrained('orders'); // foreign key
            $table->string('status')->default('pending')->nullable();
            $table->string('date_created')->default(now())->nullable();
            $table->string('date_updated')->default(now())->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_collection_item');
    }
};
