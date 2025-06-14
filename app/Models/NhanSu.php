<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NhanSu extends Model
{
    protected $table = 'nhan_su';
    protected $primaryKey = 'ma_nv';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'ma_nv',
        'ho_ten',
        'gioi_tinh',
        'ngay_sinh',
        'sdt',
        'hinh_anh',
        'dia_chi',
        'id_chuc_vu',
        'id_phong_ban',
        'id_trinh_do',
        'trang_thai'
    ];
    
    protected $casts = [
        'ngay_sinh' => 'date',
        'trang_thai' => 'boolean'
    ];
    
    public function chucVu(): BelongsTo
    {
        return $this->belongsTo(ChucVu::class, 'id_chuc_vu');
    }
    
    public function phongBan(): BelongsTo
    {
        return $this->belongsTo(PhongBan::class, 'id_phong_ban');
    }
    
    public function trinhDo(): BelongsTo
    {
        return $this->belongsTo(TrinhDo::class, 'id_trinh_do');
    }

    /**
     * The PhuCap that belong to the NhanSu.
     */
    public function phuCap()
    {
        return $this->belongsToMany(PhuCap::class, 'nhan_vien_phu_cap', 'ma_nv', 'id_phu_cap')
                    ->withPivot('ghi_chu')
                    ->withTimestamps();
    }
}
