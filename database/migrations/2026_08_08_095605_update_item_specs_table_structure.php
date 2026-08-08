<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_specs', function (Blueprint $table) {
            // 1. Hapus kolom-kolom lama yang tidak dipakai
            $table->dropColumn([
                'item_name',
                'sap_code',
                'brand',
                'model_type',
                'dimensions',
                'requirements',
                'image_path'
            ]);

            // 2. Tambahkan kolom-kolom baru sesuai spesifikasi cetak & tinta
            $table->string('item_code')->after('id');
            $table->integer('sequence')->comment('Printing sequence order from 1 to 12')->after('item_code');
            $table->string('colour')->comment('Printing colour corresponding to sequence')->after('sequence');
            $table->string('baan_cylinder')->nullable()->comment('Cylinder ID registered in BAAN ERP')->after('colour');
            $table->string('film_number')->nullable()->comment('Film identification number')->after('baan_cylinder');
            $table->string('ink_system')->nullable()->comment('Ink system specification')->after('film_number');
            $table->string('ink_code')->nullable()->comment('Ink identification code')->after('ink_system');
            $table->enum('supplier_ink', ['SIEG', 'DIC', 'HUBER', 'SC'])->nullable()->comment('Ink supplier dropdown')->after('ink_code');
            $table->string('baan_ink_code')->nullable()->comment('Ink code registered in BAAN ERP')->after('supplier_ink');
            $table->decimal('coverage', 5, 2)->nullable()->comment('Ink coverage percentage (%)')->after('baan_ink_code');
            $table->decimal('usage_kg_th', 10, 2)->nullable()->comment('Estimated annual ink consumption (Kg/TH)')->after('coverage');
            $table->string('angle_anilox')->nullable()->comment('Printing angle or anilox spec')->after('usage_kg_th');
            $table->text('remarks')->nullable()->comment('Additional notes or comments')->after('angle_anilox');
            $table->string('main_design_attachment')->nullable()->comment('File path for uploaded artwork/document')->after('remarks');
            $table->enum('project_status', ['To Do', 'Progress', 'Completed'])->default('To Do')->after('main_design_attachment');
        });
    }

    public function down(): void
    {
        Schema::table('item_specs', function (Blueprint $table) {
            // Rollback jika diperlukan
            $table->dropColumn([
                'item_code', 'sequence', 'colour', 'baan_cylinder', 'film_number',
                'ink_system', 'ink_code', 'supplier_ink', 'baan_ink_code',
                'coverage', 'usage_kg_th', 'angle_anilox', 'remarks',
                'main_design_attachment', 'project_status'
            ]);

            $table->string('item_name');
            $table->string('sap_code')->unique();
            $table->string('brand');
            $table->string('model_type');
            $table->text('dimensions')->nullable();
            $table->text('requirements')->nullable();
            $table->string('image_path')->nullable();
        });
    }
};