<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuyenCan extends Model
{
    use HasFactory;

    protected $table = 'chuyen_can';

    protected $primaryKey = ['ma_nv', 'thang_nam']; // Composite primary key
    public $incrementing = false; // Since the primary key is not auto-incrementing
    protected $keyType = 'string'; // If ma_nv is a string

    protected $fillable = [
        'ma_nv',
        'thang_nam',
        'so_cong_chuan',
        'so_ngay_di_lam',
        'so_ngay_nghi',
        'so_ngay_phep',
        'tien_thuong',
        'tien_phat',
    ];



    protected $casts = [
        'thang_nam' => 'date',
    ];

    protected function setKeysForSaveQuery($query)
    {
        foreach ($this->primaryKey as $keyName) {
            $query->where($keyName, $this->original[$keyName] ?? $this->{$keyName});
        }

        return $query;
    }



    public function nhanSu()
    {
        return $this->belongsTo(NhanSu::class, 'ma_nv', 'ma_nv');
    }
}