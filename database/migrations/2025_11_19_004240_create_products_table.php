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
            $table->string('name')->unique(); // Ensures unique product names
            $table->decimal('price', 8, 2)->default(0.00); // Price, allowing 8 digits total, 2 after decimal
            $table->integer('stock')->default(0); // Example inventory tracking
            $table->text('description')->nullable(); // Longer text for details
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
