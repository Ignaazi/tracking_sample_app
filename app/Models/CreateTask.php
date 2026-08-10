<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateTask extends Model
{
    use HasFactory;

    protected $table = 'create_task';

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
    ];

    /**
     * Relasi ke model ItemSpec (Menghubungkan Item Code ke Data Spesifikasi Warna 29-42)
     */
    public function itemSpecs()
    {
        return $this->hasMany(ItemSpec::class, 'item_code', 'item_code');
    }
}