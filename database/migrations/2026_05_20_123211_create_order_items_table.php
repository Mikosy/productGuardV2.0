<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Pointers to group these items under their parent order
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            // The unique personalized tracking string (e.g., JOHN-ABIA-001)
            $table->string('item_tracking_id')->unique(); 
            // Item state management
            $table->enum('status', ['paid', 'collected', 'damaged'])->default('paid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
