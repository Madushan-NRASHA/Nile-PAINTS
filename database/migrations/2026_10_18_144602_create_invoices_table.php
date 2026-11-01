<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Invoice ID
            // Customer සම්බන්ධ කිරීම සඳහා (foreignId)
            $table->foreignId('cus_id')->constrained('customers')->onDelete('cascade');
            
            $table->date('date'); // Invoice Date
            
            // ඔබට අවශ්‍ය නම් Item එකක්ද මෙහි සම්බන්ධ කළ හැක, 
            // නැතහොත් ඔබ ඉල්ලා ඇති පරිදි නම සහ විස්තර ලබා දීමටද හැක.
            $table->string('item_name'); 
            $table->integer('qty');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 12, 2); // Total Amount
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};