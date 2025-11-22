<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (! $user->role) {
                $user->role = 'pembeli';
            }
        });
    }


    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

 function isPembeli(): bool
    {
        return $this->role === 'pembeli';
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'user_id', 'id');
    }

}
