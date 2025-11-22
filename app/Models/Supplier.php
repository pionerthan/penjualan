<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Supplier extends Model
{
    protected $table = 'Supplier';
    protected $primaryKey = 'SupplierID';
    protected $fillable = [
    'NamaSupplier', 'Alamat', 'NomorTelepon',
    ];
}