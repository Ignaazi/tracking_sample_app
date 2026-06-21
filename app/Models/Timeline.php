<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // 🌟 PASTIKAN ADALAH Eloquent\Model BUKAN Database\Model

class Timeline extends Model
{
    use HasFactory;

    protected $table = 'timelines'; // Menegaskan nama tabel di database

    protected $fillable = [
        'project_name',
        'phase',
        'task_title',
        'start_date',
        'end_date',
        'progress_percent'
    ];
}