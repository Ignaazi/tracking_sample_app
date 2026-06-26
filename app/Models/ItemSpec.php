<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSpec extends Model
{
    use HasFactory;

    protected $table = 'item_specs';

    protected $fillable = [
        'item_name',
        'sap_code',
        'brand',
        'model_type',
        'dimensions',
        'requirements',
        'image_path'
    ];
}