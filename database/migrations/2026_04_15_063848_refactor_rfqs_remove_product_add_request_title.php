<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rfqs', function (Blueprint $table) {
            $table->string('request_title')->nullable()->after('client_user_id');
        });

        DB::table('rfqs')
            ->join('products', 'products.id', '=', 'rfqs.product_id')
            ->update(['rfqs.request_title' => DB::raw('products.name')]);

        DB::table('rfqs')
            ->whereNull('request_title')
            ->update(['request_title' => 'Permintaan Penawaran']);

        Schema::table('rfqs', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }

    public function down(): void
    {
        Schema::table('rfqs', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('request_title')->constrained()->restrictOnDelete();
        });

        Schema::table('rfqs', function (Blueprint $table) {
            $table->dropColumn('request_title');
        });
    }
};
