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
        Schema::create('nhan_vien_phu_cap', function (Blueprint $table) {
            $table->string('ma_nv');
            $table->unsignedBigInteger('id_phu_cap');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();

            $table->foreign('ma_nv')->references('ma_nv')->on('nhan_su')->onDelete('cascade');
            $table->foreign('id_phu_cap')->references('id')->on('phu_cap')->onDelete('cascade');

            $table->primary(['ma_nv', 'id_phu_cap']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_vien_phu_cap');
    }
};
