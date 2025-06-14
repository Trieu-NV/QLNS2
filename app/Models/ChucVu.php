<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChucVu extends Model
{
    protected $table = 'chuc_vu';
    
    protected $fillable = [
        'ten_chuc_vu',
        'mo_ta'
    ];
    
    public function nhanSu()
    {
        return $this->hasMany(NhanSu::class, 'id_chuc_vu');
    }
}
