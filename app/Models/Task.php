<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // WAJIB Ditambahkan: Mengunci nama tabel ke bentuk tunggal 'task'
    protected $table = 'task';

    // 1. Definisikan 'item_code' sebagai Primary Key
    protected $primaryKey = 'item_code';

    // 2. Matikan auto-increment karena primary key-nya string
    public $incrementing = false;

    // 3. Set tipe data primary key ke string
    protected $keyType = 'string';

    // 4. Update daftar kolom yang diizinkan untuk mass-assignment (Total 42 kolom + status tracker bawaan)
    protected $fillable = [
        // Primary Key & Tracker No
        'no',
        'item_code',

        // Core Identity & Project (Kolom 3 - 12)
        'brand_family',
        'market',
        'project_name', // Sesuai kolom 5. Project / Project Name
        'ascis_pd',     // Sesuai kolom 6. PD ASCIS / ascis_pd
        'customer',     // Sesuai kolom 7. Customer
        'cs_brand',
        'cs_hw',
        'cpi_hw',
        's5_internal_approval',
        'ghw_set',

        // Dates (Kolom 13 - 14)
        'information_received',
        'plm_released',

        // Specs & Codes (Kolom 15 - 28)
        'coi_number',
        'green_light',
        'td',
        'machine',
        'board',
        'board_u_code',
        'board_a_code',
        'type_cm',
        'die_cut_number',
        's10_number',
        's11_number',
        's12_number',
        'cylinder_supplier',
        'repro_by',

        // Cylinder & Ink (Kolom 29 - 36)
        'sequence_seq',
        'colour',
        'baan_cylinder',
        'film_number',
        'ink_system',
        'ink_code',
        'supplier_ink',
        'baan_ink_code',

        // Measures (Kolom 37 - 39)
        'coverage_percent',
        'usage_kg_th',
        'angle_anilox',

        // Remarks & Attachment (Kolom 40 - 41)
        'remark',                 // Sesuai kolom 40. Remarks / remark
        'main_design_attachment', // Sesuai kolom 41. Main Design / Attachment

        // Statuses (Kolom 42 + Status Internal Kanban Bawaan)
        'status',                 // Sesuai 'Project Status'
        'development_status',
        'layout_status',
        'baan_status',
        'promp_status',
        'job_bag_status',

        // Tambahan SAP Number dari sistem lama
        'sap_number'
    ];
}