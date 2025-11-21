<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'subjek',
        'pesan',
    ];
}