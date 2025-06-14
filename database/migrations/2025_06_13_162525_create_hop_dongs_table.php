<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hop_dong', function (Blueprint $table) {
            $table->string('id', 7)->primary(); // Mã hợp đồng, Format: HD00001
            $table->string('ma_nv'); // Mã nhân viên (khóa ngoại)
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_su')->onDelete('cascade');
            $table->tinyInteger('loai_hop_dong')->comment('1: Hợp đồng xác định thời hạn, 2: Hợp đồng không xác định thời hạn');
            $table->decimal('luong', 15, 2); // Lương
            $table->date('ngay_bat_dau'); // Ngày bắt đầu
            $table->date('ngay_ket_thuc')->nullable(); // Ngày kết thúc (có thể null cho hợp đồng không xác định thời hạn)
            $table->date('ngay_ky'); // Ngày ký
            $table->integer('so_lan_ky')->default(1); // Số lần ký (mặc định là 1 cho lần ký đầu tiên)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hop_dong');
    }
};
