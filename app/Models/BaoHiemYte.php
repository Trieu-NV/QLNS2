<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaoHiemYte extends Model
{
    protected $table = 'bao_hiem_yte';
    protected $primaryKey = 'idbh';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idbh',
        'ma_nv',
        'so_bao_hiem',
        'ngay_cap',
        'noi_cap',
        'noi_kham_benh',
    ];

    public function nhanSu()
    {
        return $this->belongsTo(NhanSu::class, 'ma_nv', 'ma_nv');
    }
}
