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
        Schema::create('nhan_su', function (Blueprint $table) {
            $table->string('ma_nv')->unique()->primary();
            $table->string('ho_ten');
            $table->enum('gioi_tinh', ['Nam', 'Nữ', 'Khác']);
            $table->date('ngay_sinh');
            $table->string('sdt', 15)->nullable();
            $table->string('hinh_anh')->nullable();
            $table->text('dia_chi')->nullable();
            $table->foreignId('id_chuc_vu')->constrained('chuc_vu')->onDelete('cascade');
            $table->foreignId('id_phong_ban')->constrained('phong_ban')->onDelete('cascade');
            $table->foreignId('id_trinh_do')->constrained('trinh_do')->onDelete('cascade');
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_su');
    }
};
