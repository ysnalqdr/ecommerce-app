<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('original_price', 12, 2)->nullable()->after('price');
            $table->integer('discount_percent')->default(0)->after('original_price');
            $table->integer('total_sold')->default(0)->after('discount_percent');
            $table->enum('badge', ['none', 'official', 'local'])->default('none')->after('total_sold');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'discount_percent', 'total_sold', 'badge']);
        });
    }
};