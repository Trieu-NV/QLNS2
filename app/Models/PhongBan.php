<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhongBan extends Model
{
    protected $table = 'phong_ban';
    
    protected $fillable = [
        'ten_phong_ban',
        'mo_ta'
    ];
    
    public function nhanSu()
    {
        return $this->hasMany(NhanSu::class, 'id_phong_ban');
    }
}
