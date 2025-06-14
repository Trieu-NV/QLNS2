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
        Schema::create('cham_cong', function (Blueprint $table) {
            $table->id();
            $table->string('ma_nv');
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_su')->onDelete('cascade');
            $table->date('ngay');
            $table->enum('trang_thai', ['Đi Làm', 'Nghỉ', 'Phép'])->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cham_cong');
    }
};
