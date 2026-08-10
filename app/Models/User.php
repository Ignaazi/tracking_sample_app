<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'nik', 'password', 'role', 'signature'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    // 👈 2. MASUKKAN HasApiTokens DI SINI AGAR METHOD createToken() AKTIF!
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Beritahu Laravel kalau login-nya menggunakan NIK, bukan Email.
     *
     * @return string
     */
    public function username()
    {
        return 'nik';
    }

    /**
     * Get the attributes that should be cast.
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