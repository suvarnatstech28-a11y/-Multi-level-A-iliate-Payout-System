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
       Schema::table('users', function (Blueprint $table) {
            // 1. Add the foreign key column (ensures it's the correct type)
            $table->foreignId('customer_id')
                  ->nullable() // Make it nullable if a User might not always have a Customer profile immediately
                  ->after('id') // Place it right after the primary 'id' column
                  ->constrained('customers') // 2. Create the foreign key constraint
                  ->onDelete('cascade'); // OPTIONAL: If the customer is deleted, also delete the user record
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 3. Drop the foreign key constraint first
            $table->dropConstrainedForeignId('customer_id');
        });
    }
};
