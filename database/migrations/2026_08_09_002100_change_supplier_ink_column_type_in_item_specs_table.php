<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_specs', function (Blueprint $table) {
            // Mengubah tipe kolom supplier_ink menjadi string/varchar biasa (panjang 255)
            $table->string('supplier_ink', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('item_specs', function (Blueprint $table) {
            $table->string('supplier_ink', 50)->change();
        });
    }
};