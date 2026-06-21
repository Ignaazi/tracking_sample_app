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
    Schema::create('samples', function (Blueprint $table) {
        $table->id();
        $table->string('item_code')->unique();       // Kolom 'Item Code' (Untuk di-scan, misal: IC-001)
        $table->string('title');                     // Kolom 'Title' (Nama Project, misal: Project A)
        $table->string('brand')->nullable();          // Kolom 'Brand' (Nestle, Unilever, dll)
        $table->string('priority')->nullable();       // Kolom 'Priority' (Low, High)
        $table->string('customer_code')->nullable();  // Kolom 'Customer Code' (CUS-001)
        $table->string('market')->nullable();         // Kolom 'Market' (Indonesia, Singapore)
        $table->string('technical_drawing')->nullable(); // Kolom 'Technical Drawing' (TD-001.pdf)
        $table->string('board')->nullable();          // Kolom 'Board' (Ivory 350gsm)
        $table->string('mixing')->nullable();         // Kolom 'Mixing' (Mix A)
        $table->string('ghw_set')->nullable();        // Kolom 'GHW Set' (GHW-001)
        $table->string('pd_customer')->nullable();    // Kolom 'PD Customer' (Hibram Nuruddin)
        $table->string('add_by')->nullable();         // Kolom 'Add By' (Mohammad Yusron Safano)
        $table->string('status')->default('To Do');   // Kolom 'Status' (To Do, In Progress, Ready)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
