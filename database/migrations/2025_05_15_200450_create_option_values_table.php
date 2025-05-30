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
        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained()->onDelete('cascade');
            $table->string('value'); // مثل "Chicken", "Beef", "Shrimp"
            $table->decimal('additional_price', 8, 2)->default(0); // سعر إضافي إن وجد
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_values');
    }
};
