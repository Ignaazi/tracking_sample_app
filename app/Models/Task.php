<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // WAJIB Ditambahkan: Mengunci nama tabel ke bentuk tunggal 'task'
    protected $table = 'task';

    protected $fillable = [
        'project_name',
        'customer',
        'item_code',
        'sap_number',
        'brand_family',
        'market',
        'ascis_pd',
        'cs_brand',
        'cs_hw',
        'ghw_set',
        'status',
        'development_status',
        'layout_status',
        'baan_status',
        'promp_status',
        'job_bag_status',
        'remark'
    ];
}