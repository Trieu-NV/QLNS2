<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrinhDo extends Model
{
    protected $table = 'trinh_do';
    
    protected $fillable = [
        'ten_trinh_do',
        'mo_ta'
    ];
    
    public function nhanSu()
    {
        return $this->hasMany(NhanSu::class, 'id_trinh_do');
    }
}
