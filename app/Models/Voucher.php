<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'kode_voucher',
        'diskon_persen',
        'mulai_berlaku',
        'kadaluarsa',
        'limit_penggunaan',
        'digunakan',
    ];

    protected $atttibutes = [
        'digunakan' => 0,
    ];

    public function isValid(): bool
    {
        $today = Carbon::today();

        return $this->mulai_berlaku <= $today
            && $this->kadaluarsa >= $today
            && ($this->limit_penggunaan == 0 || $this->digunakan < $this->limit_penggunaan);
    }
}
