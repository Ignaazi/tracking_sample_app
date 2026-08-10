<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $table = 'timelines'; // Menegaskan nama tabel di database

    protected $fillable = [
        'task_id',
        'project_name',
        'phase',
        'section_key',
        'task_title',
        'start_date',
        'end_date',
        'progress_percent',
        'is_completed'
    ];

    /**
     * Casts tipe data otomatis
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_completed' => 'boolean',
    ];

    /**
     * Relasi balik ke Task (Many to One)
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}