<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Stores path to proof image if items arrive ruined
            $table->string('damage_proof_image')->nullable()->after('status');
            $table->text('damage_notes')->nullable()->after('damage_proof_image');
            
            // Track if Admin has processed the refund decision
            $table->boolean('admin_refund_processed')->default(false)->after('damage_notes');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['damage_proof_image', 'damage_notes', 'admin_refund_processed']);
        });
    }
};