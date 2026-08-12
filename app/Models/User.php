<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nik',
        'password',
        'role',
        'signature',
    ];

    /**
     * Kolom yang disembunyikan saat data diserialisasi ke JSON (misal di API Flutter).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Menentukan kolom utama untuk otentikasi (NIK).
     *
     * @return string
     */
    public function username()
    {
        return 'nik';
    }

    /**
     * Tipe data casting bawaan.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}