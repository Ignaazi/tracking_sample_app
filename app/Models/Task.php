<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'task';

    // Primary Key berupa item_code
    protected $primaryKey = 'item_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no',
        'item_code',
        'brand_family',
        'market',
        'project_name',
        'ascis_pd',
        'customer',
        'cs_brand',
        'cs_hw',
        'cpi_hw',
        's5_internal_approval',
        'ghw_set',
        'information_received',
        'plm_released',
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
        'sequence_seq',
        'colour',
        'baan_cylinder',
        'film_number',
        'ink_system',
        'ink_code',
        'supplier_ink',
        'baan_ink_code',
        'coverage_percent',
        'usage_kg_th',
        'angle_anilox',
        'remark',
        'main_design_attachment',
        'status',
        'development_status',
        'layout_status',
        'baan_status',
        'promp_status',
        'job_bag_status',
        'sap_number'
    ];

    /**
     * RELASI PENTING (Mencegah RelationNotFoundException)
     * Menghubungkan Task ke ItemSpec berdasarkan item_code
     */
    public function itemSpecs()
    {
        return $this->hasMany(ItemSpec::class, 'item_code', 'item_code');
    }
}