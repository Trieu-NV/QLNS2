<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HopDong extends Model
{
    protected $table = 'hop_dong';
    
    protected $primaryKey = 'id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';

    protected $fillable = [
        'id', // Mã hợp đồng
        'ma_nv', // Mã nhân viên
        'loai_hop_dong', // 1: Hợp đồng xác định thời hạn, 2: Hợp đồng không xác định thời hạn
        'luong', // Lương
        'ngay_bat_dau', // Ngày bắt đầu
        'ngay_ket_thuc', // Ngày kết thúc (nullable)
        'ngay_ky', // Ngày ký
        'so_lan_ky', // Số lần ký
    ];

    protected $casts = [
        'luong' => 'decimal:2',
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date', // Sẽ được xử lý là nullable ở cấp độ DB
        'ngay_ky' => 'date',
        'loai_hop_dong' => 'integer',
        'so_lan_ky' => 'integer',
    ];

    public function nhanSu(): BelongsTo
    {
        return $this->belongsTo(NhanSu::class, 'ma_nv', 'ma_nv');
    }

    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            // Auto-generate HD ID
            $latestHD = static::orderBy('id', 'desc')->first();
            
            if ($latestHD) {
                $number = intval(substr($latestHD->id, 2)) + 1;
            } else {
                $number = 1;
            }
            
            $model->id = 'HD' . str_pad($number, 5, '0', STR_PAD_LEFT);
        });
    }

    public function getLoaiHopDongTextAttribute(): string
    {
        return match($this->loai_hop_dong) {
            1 => 'Hợp đồng xác định thời hạn',
            2 => 'Hợp đồng không xác định thời hạn',
            default => 'Không xác định'
        };
    }
}
