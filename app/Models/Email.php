<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $table = 'emails';

    /**
     * Kolom yang diizinkan untuk pengisian massal (Mass Assignment)
     */
    protected $fillable = [
        'sender_name',
        'sender_email',
        'subject',
        'message',
        'label',
        'folder',      // Berhasil ditambahkan sesuai kebutuhan migrasi folder baru
        'is_starred',
        'is_read'
    ];

    /**
     * Aturan Konversi Tipe Data (Casting) otomatis dari Database
     */
    protected $casts = [
        'is_starred' => 'boolean',
        'is_read'    => 'boolean',
    ];
}