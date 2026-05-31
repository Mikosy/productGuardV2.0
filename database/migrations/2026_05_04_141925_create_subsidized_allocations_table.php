<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('subsidized_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('allocation_batch_id')->constrained()->onDelete('cascade');
            $table->string('state_name'); // The specific state (Kano, Lagos, etc.)
            $table->integer('state_quota'); // Amount for this state
            $table->integer('remaining_quota'); // Tracks remaining stock as users order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    
    public function down()
    {
        Schema::dropIfExists('subsidized_allocations');
    }

    
};
