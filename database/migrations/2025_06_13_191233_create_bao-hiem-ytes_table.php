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
        Schema::create('bao_hiem_yte', function (Blueprint $table) {
            $table->string('idbh', 7)->primary(); // Mã bảo hiểm, Format: BH00001
            $table->string('so_bao_hiem', 10)->unique();
            $table->date('ngay_cap');
            $table->string('noi_cap');
            $table->string('noi_kham_benh');
            $table->string('ma_nv');
            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_su')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bao_hiem_yte');
    }
};
