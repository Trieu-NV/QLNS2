<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Taikhoan extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'tai_khoan';
    protected $primaryKey = 'taikhoan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'taikhoan',
        'matkhau',
        'loaitk',
        'sdt',
        'email',
        'info',
    ];
    protected $hidden = [
        'matkhau',
    ];
    protected function casts(): array
    {
        return [];
    }
}