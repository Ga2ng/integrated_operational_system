<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('rfq_material_items') || ! Schema::hasTable('rfqs')) {
            return;
        }

        $constraintExists = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'rfq_material_items')
            ->where('CONSTRAINT_NAME', 'rfq_material_items_rfq_id_foreign')
            ->exists();

        if (! $constraintExists) {
            Schema::table('rfq_material_items', function (Blueprint $table) {
                $table->foreign('rfq_id')->references('id')->on('rfqs')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('rfq_material_items')) {
            return;
        }

        $constraintExists = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'rfq_material_items')
            ->where('CONSTRAINT_NAME', 'rfq_material_items_rfq_id_foreign')
            ->exists();

        if ($constraintExists) {
            Schema::table('rfq_material_items', function (Blueprint $table) {
                $table->dropForeign('rfq_material_items_rfq_id_foreign');
            });
        }
    }
};
