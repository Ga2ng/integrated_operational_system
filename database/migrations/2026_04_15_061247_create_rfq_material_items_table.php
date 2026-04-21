<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfq_material_items', function (Blueprint $table) {
            $table->id();
            // RFQ table created in later migration; FK added later.
            $table->unsignedBigInteger('rfq_id');
            $table->foreignId('material_inventory_id')->constrained('material_inventories')->restrictOnDelete();
            $table->decimal('qty_needed', 14, 2)->default(0);
            $table->decimal('estimated_cost', 14, 2)->default(0);
            $table->timestamps();

            $table->index('rfq_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfq_material_items');
    }
};
