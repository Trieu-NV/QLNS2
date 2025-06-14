<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuCap extends Model
{
    /** @use HasFactory<\Database\Factories\PhuCapFactory> */
    use HasFactory;
    protected $table = 'phu_cap';
    protected $fillable = [
        'phu_cap_name',
        'so-tien',
        'mo-ta'
    ];
    protected $casts = [
        'so-tien' => 'float'
    ];

    /**
     * The NhanSu that belong to the PhuCap.
     */
    public function nhanSu()
    {
        return $this->belongsToMany(NhanSu::class, 'nhan_vien_phu_cap', 'id_phu_cap', 'ma_nv')
                    ->withPivot('ghi_chu')
                    ->withTimestamps();
    }
}
