<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSpec extends Model
{
    use HasFactory;

    protected $table = 'item_specs';

    protected $fillable = [
        'item_code',
        'sequence',
        'colour',
        'baan_cylinder',
        'film_number',
        'ink_system',
        'ink_code',
        'supplier_ink',
        'baan_ink_code',
        'coverage',
        'usage_kg_th',
        'angle_anilox',
        'remarks',
        'main_design_attachment',
        'project_status',
    ];

    /**
     * Relasi balik ke Model Task/Project Utama menggunakan item_code
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'item_code', 'item_code');
    }
}