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
        Schema::table('allocation_batches', function (Blueprint $table) {
            $table->decimal('market_price', 15, 2)->after('total_quantity');
            $table->decimal('subsidized_price', 15, 2)->after('market_price');
            $table->integer('max_per_user')->default(1)->after('subsidized_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allocation_batches', function (Blueprint $table) {
            //
        });
    }
};
