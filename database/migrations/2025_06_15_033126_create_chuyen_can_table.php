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
        Schema::create('chuyen_can', function (Blueprint $table) {
            $table->string('ma_nv');
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_su')->onDelete('cascade');
            $table->date('thang_nam'); // Format YYYY-MM
            $table->integer('so_cong_chuan');
            $table->integer('so_ngay_di_lam')->default(0);
            $table->integer('so_ngay_nghi')->default(0);
            $table->integer('so_ngay_phep')->default(0);
            $table->decimal('tien_thuong', 15, 2)->default(0);
            $table->decimal('tien_phat', 15, 2)->default(0);
            $table->primary(['ma_nv', 'thang_nam']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chuyen_can');
    }
};
