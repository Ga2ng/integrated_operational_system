<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('rfqs')) {
            return;
        }

        if (! Schema::hasColumn('rfqs', 'request_title')) {
            Schema::table('rfqs', function (Blueprint $table) {
                $table->string('request_title')->nullable()->after('client_user_id');
            });
        }

        if (Schema::hasColumn('rfqs', 'product_id') && Schema::hasTable('products')) {
            DB::table('rfqs')
                ->join('products', 'products.id', '=', 'rfqs.product_id')
                ->update(['rfqs.request_title' => DB::raw('products.name')]);
        }

        DB::table('rfqs')
            ->whereNull('request_title')
            ->update(['request_title' => 'Permintaan Penawaran']);

        if (Schema::hasColumn('rfqs', 'product_id')) {
            Schema::table('rfqs', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            });
        }

        if (Schema::hasTable('rfq_material_items') && Schema::hasTable('rfqs')) {
            Schema::table('rfq_material_items', function (Blueprint $table) {
                $table->foreign('rfq_id')->references('id')->on('rfqs')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('rfq_material_items', function (Blueprint $table) {
            $table->dropForeign(['rfq_id']);
        });

        Schema::table('rfqs', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('request_title')->constrained()->restrictOnDelete();
        });

        Schema::table('rfqs', function (Blueprint $table) {
            $table->dropColumn('request_title');
        });
    }
};
