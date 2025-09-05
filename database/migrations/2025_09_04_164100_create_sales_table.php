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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable(); // optional if kiosk doesn't use customer name
            $table->string('service')->nullable(); // optional, can store "Kiosk Order" or service type
            $table->string('order_method'); // Takeout / Dine-in
            $table->string('table_number')->nullable(); // only needed if Dine-in
            $table->string('payment_method'); // Cash / GCash
            $table->decimal('total', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
