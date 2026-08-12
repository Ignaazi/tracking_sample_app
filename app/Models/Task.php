<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Nama tabel di database db_sample_app
    protected $table = 'task';

    // Primary Key bawaan tabel
    protected $primaryKey = 'id';

    // Membuka seluruh kolom untuk Mass Assignment
    protected $guarded = [];

    /**
     * Default nilai atribut saat instance model dibuat
     */
    protected $attributes = [
        'status'             => 'todo',
        'development_status' => 'Active',
        'layout_status'      => 'Pending',
        'baan_status'        => 'Pending',
        'promp_status'       => 'Pending',
        'job_bag_status'     => 'Pending',
    ];

    /**
     * Casting tipe data kolom tanggal & angka agar otomatis berformat Carbon / Decimal
     */
    protected $casts = [
        'information_received' => 'date',
        'plm_released'         => 'date',
        'green_light'          => 'date',
        'pd_prepared_at'       => 'datetime',
        'qa_checked_at'        => 'datetime',
        'planner_approved_at'  => 'datetime',
        'coverage_percent'     => 'decimal:2',
        'usage_kg_th'          => 'decimal:3',
    ];

    /**
     * Relasi ke ItemSpec (One-to-Many) berdasarkan item_code
     */
    public function itemSpecs()
    {
        return $this->hasMany(ItemSpec::class, 'item_code', 'item_code');
    }

    /**
     * Relasi ke Timeline (One-to-Many)
     * Mengaitkan Task dengan poin sub-process checklist timeline
     */
    public function timelines()
    {
        return $this->hasMany(Timeline::class, 'task_id', 'id');
    }

    /**
     * Relasi ke Sample (BelongsTo / HasOne) berdasarkan item_code
     */
    public function sample()
    {
        return $this->belongsTo(Sample::class, 'item_code', 'item_code');
    }

    /**
     * Relasi ke User yang me-sign PREPARED (PD)
     */
    public function pdUser()
    {
        return $this->belongsTo(User::class, 'pd_prepared_by');
    }

    /**
     * Relasi ke User yang me-sign CHECKED (QA)
     */
    public function qaUser()
    {
        return $this->belongsTo(User::class, 'qa_checked_by');
    }

    /**
     * Relasi ke User yang me-sign APPROVED (PLANNER)
     */
    public function plannerUser()
    {
        return $this->belongsTo(User::class, 'planner_approved_by');
    }

    /**
     * Helper untuk cek apakah project sudah fully approved oleh ketiga pihak (PD, QA, PLANNER)
     */
    public function isFullyApproved(): bool
    {
        return !is_null($this->pd_prepared_at) && 
               !is_null($this->qa_checked_at) && 
               !is_null($this->planner_approved_at);
    }
}