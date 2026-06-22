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
        Schema::table('emails', function (Blueprint $table) {
            // Cek jika kolom 'folder' BELUM ada, baru tambahkan
            if (!Schema::hasColumn('emails', 'folder')) {
                $table->string('folder')->default('inbox')->after('label');
            }
            
            // Cek jika kolom 'is_read' BELUM ada, baru tambahkan
            if (!Schema::hasColumn('emails', 'is_read')) {
                $table->boolean('is_read')->default(false)->after('folder');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->dropColumn(['folder', 'is_read']);
        });
    }
};