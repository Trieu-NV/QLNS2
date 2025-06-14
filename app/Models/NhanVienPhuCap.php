<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NhanVienPhuCap extends Pivot
{
    protected $table = 'nhan_vien_phu_cap';

    protected $primaryKey = ['ma_nv', 'id_phu_cap'];
    public $incrementing = false;

    protected $fillable = [
        'ma_nv',
        'id_phu_cap',
        'ghi_chu',
    ];

    /**
     * Get the NhanSu that owns the NhanVienPhuCap.
     */
    public function nhanSu()
    {
        return $this->belongsTo(NhanSu::class, 'ma_nv', 'ma_nv');
    }

    /**
     * Get the PhuCap that owns the NhanVienPhuCap.
     */
    public function phuCap()
    {
        return $this->belongsTo(PhuCap::class, 'id_phu_cap', 'id');
    }
}