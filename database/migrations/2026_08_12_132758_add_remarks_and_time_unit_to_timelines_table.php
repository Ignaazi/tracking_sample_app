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
        Schema::table('timelines', function (Blueprint $table) {
            // Sesuaikan tipe data 'remarks' dan 'time_unit' dengan kebutuhan
            $table->text('remarks')->nullable()->after('id'); 
            $table->string('time_unit')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->dropColumn(['remarks', 'time_unit']);
        });
    }
};