<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaoHiemXaHoi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nhan_su_id',
        'thang_nam',
        'luong_dong_bao_hiem',
        'bhxh_nv', 'bhyt_nv', 'bhtn_nv', 'tong_nv',
        'bhxh_dn', 'bhyt_dn', 'bhtn_dn', 'kinh_phi_cong_doan', 'tong_dn',
    ];

    public function nhanSu()
    {
        return $this->belongsTo(NhanSu::class, 'nhan_su_id');
    }
} 