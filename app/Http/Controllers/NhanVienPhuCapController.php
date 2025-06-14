<?php

namespace App\Http\Controllers;

use App\Models\NhanVienPhuCap;
use App\Models\NhanSu;
use App\Models\PhuCap;
use Illuminate\Http\Request;

class NhanVienPhuCapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = NhanVienPhuCap::with(['nhanSu', 'phuCap']);

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->whereHas('nhanSu', function ($q) use ($searchTerm) {
                $q->where('ho_ten', 'like', "%{$searchTerm}%");
            })->orWhereHas('phuCap', function ($q) use ($searchTerm) {
                $q->where('phu_cap_name', 'like', "%{$searchTerm}%");
            });
        }

        $nhanVienPhuCaps = $query->paginate(10);
        return view('phu-cap.nhan-vien.index', compact('nhanVienPhuCaps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nhanSus = NhanSu::where('trang_thai', true)->get();
        $phuCaps = PhuCap::all();
        return view('phu-cap.nhan-vien.create', compact('nhanSus', 'phuCaps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ma_nv' => 'required|exists:nhan_su,ma_nv',
            'id_phu_cap' => 'required|exists:phu_cap,id',
            'ghi_chu' => 'nullable|string',
        ]);

        NhanVienPhuCap::create($request->all());

        return redirect()->route('nhan-vien-phu-cap.index')
            ->with('success', 'Nhân viên phụ cấp đã được thêm thành công.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($ma_nv, $id_phu_cap) // Adjusted to accept composite key parts
    {
        $nhanVienPhuCap = NhanVienPhuCap::where('ma_nv', $ma_nv)->where('id_phu_cap', $id_phu_cap)->firstOrFail();
        $nhanSus = NhanSu::all();
        $phuCaps = PhuCap::all();
        return view('phu-cap.nhan-vien.edit', compact('nhanVienPhuCap', 'nhanSus', 'phuCaps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $ma_nv, $id_phu_cap) // Adjusted to accept composite key parts
    {
        $request->validate([
            'ghi_chu' => 'nullable|string',
        ]);

        $nhanVienPhuCap = NhanVienPhuCap::where('ma_nv', $ma_nv)->where('id_phu_cap', $id_phu_cap)->firstOrFail();
        $nhanVienPhuCap->update($request->only('ghi_chu'));

        return redirect()->route('nhan-vien-phu-cap.index')
            ->with('success', 'Thông tin phụ cấp của nhân viên đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ma_nv, $id_phu_cap) // Adjusted to accept composite key parts
    {
        $nhanVienPhuCap = NhanVienPhuCap::where('ma_nv', $ma_nv)->where('id_phu_cap', $id_phu_cap)->firstOrFail();
        $nhanVienPhuCap->delete();

        return redirect()->route('nhan-vien-phu-cap.index')
            ->with('success', 'Phụ cấp của nhân viên đã được xóa thành công.');
    }
}