<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamCong extends Model
{
    use HasFactory;

    protected $table = 'cham_cong';

    protected $fillable = [
        'ma_nv',
        'ngay',
        'trang_thai',
        'ghi_chu',
    ];

    /**
     * Get the nhan_su that owns the ChamCong.
     */
    public function nhanSu()
    {
        return $this->belongsTo(NhanSu::class, 'ma_nv', 'ma_nv');
    }
}