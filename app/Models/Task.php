<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'task';

    // Primary Key bawaan tabel
    protected $primaryKey = 'id';

    // Menggunakan $guarded = [] agar semua kolom dapat dimasukkan secara Mass Assignment
    // tanpa perlu khawatir ada atribut/kolom baru yang tertinggal di $fillable
    protected $guarded = [];

    /**
     * Casting tipe data kolom tanggal & angka agar otomatis berformat Carbon / Decimal
     */
    protected $casts = [
        'information_received' => 'date',
        'plm_released'         => 'date',
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
}