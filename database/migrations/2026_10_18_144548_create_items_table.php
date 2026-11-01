<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('item_name'); // Item name
            $table->decimal('unit_price', 10, 2); // Unit price
            $table->integer('qty'); // Quantity
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};