<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bao_hiem_xa_hois', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nhan_su_id');
            $table->string('thang_nam'); // định dạng: yyyy-mm
            $table->decimal('luong_dong_bao_hiem', 15, 2);
            // Người lao động
            $table->decimal('bhxh_nv', 15, 2);
            $table->decimal('bhyt_nv', 15, 2);
            $table->decimal('bhtn_nv', 15, 2);
            $table->decimal('tong_nv', 15, 2);
            // Doanh nghiệp
            $table->decimal('bhxh_dn', 15, 2);
            $table->decimal('bhyt_dn', 15, 2);
            $table->decimal('bhtn_dn', 15, 2);
            $table->decimal('kinh_phi_cong_doan', 15, 2);
            $table->decimal('tong_dn', 15, 2);
            $table->timestamps();

            $table->foreign('nhan_su_id')->references('id')->on('nhan_sus')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bao_hiem_xa_hois');
    }
}; 