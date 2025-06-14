<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChamCong;
use App\Models\NhanSu;
use App\Models\PhongBan;
use Carbon\Carbon;

class ChamCongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ngayLoc = $request->input('ngay', now()->toDateString());

        // Kiểm tra nếu ngày lọc là ngày trong tương lai thì không cho phép
        if (Carbon::parse($ngayLoc)->isFuture()) {
            return redirect()->back()->with('error', 'Không thể xem chấm công cho ngày trong tương lai.');
        }
        // $ngayLoc= '2025-06-01';
        $phongBans = PhongBan::all();

        // Tạo bản ghi chấm công cho nhân viên nếu chưa có cho ngày hôm nay
        $nhanSuHoatDong = NhanSu::where('trang_thai', 1)->get();
        foreach ($nhanSuHoatDong as $nhanVien) {
            ChamCong::firstOrCreate(
                ['ma_nv' => $nhanVien->ma_nv, 'ngay' => $ngayLoc],
                ['trang_thai' => null] // Đặt trạng thái mặc định là null
            );
        }
        $query = ChamCong::with('nhanSu.phongBan')
            ->where('ngay', $ngayLoc);

        // Tìm kiếm theo tên nhân viên
        if ($request->has('search_ten_nv') && $request->search_ten_nv) {
            $search_ten_nv = $request->search_ten_nv;
            $query->whereHas('nhanSu', function ($q) use ($search_ten_nv) {
                $q->where('ho_ten', 'like', "%{$search_ten_nv}%");
            });
        }

        // Lọc theo phòng ban
        if ($request->has('phong_ban_id') && $request->phong_ban_id) {
            $phong_ban_id = $request->phong_ban_id;
            $query->whereHas('nhanSu', function ($q) use ($phong_ban_id) {
                $q->where('id_phong_ban', $phong_ban_id);
            });
        }

        $chamCongs = $query->get();

        return view('cham-cong.index', compact('chamCongs', 'phongBans', 'ngayLoc'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $chamCong = ChamCong::findOrFail($id);

        $validated = $request->validate([
            'trang_thai' => 'required|in:Đi Làm,Nghỉ,Phép',
            'ghi_chu' => 'nullable|string',
            // Thêm các validation cho loại nghỉ, loại phép nếu cần
            'loai_nghi' => 'nullable|string|required_if:trang_thai,Nghỉ',
            'loai_phep' => 'nullable|string|required_if:trang_thai,Phép',
        ]);

        // Xử lý ghi chú dựa trên trạng thái
        $ghiChu = $validated['ghi_chu'] ?? '';
        if ($validated['trang_thai'] === 'Nghỉ' && !empty($validated['loai_nghi'])) {
            $ghiChu = ($ghiChu ? $ghiChu . ' - ' : '') . 'Lý do nghỉ: ' . $validated['loai_nghi'];
        }
        if ($validated['trang_thai'] === 'Phép' && !empty($validated['loai_phep'])) {
            $ghiChu = ($ghiChu ? $ghiChu . ' - ' : '') . 'Loại phép: ' . $validated['loai_phep'];
        }

        $chamCong->update([
            'trang_thai' => $validated['trang_thai'],
            'ghi_chu' => $ghiChu,
        ]);

        if ($request->ajax()) {
            $trangThaiClass = '';
            switch ($chamCong->trang_thai) {
                case 'Đi Làm':
                    $trangThaiClass = 'success';
                    break;
                case 'Nghỉ':
                    $trangThaiClass = 'danger';
                    break;
                case 'Phép':
                    $trangThaiClass = 'warning';
                    break;
                default:
                    $trangThaiClass = 'secondary';
                    break;
            }
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật chấm công thành công!',
                'trang_thai' => $chamCong->trang_thai,
                'trang_thai_class' => $trangThaiClass,
                'ghi_chu' => $chamCong->ghi_chu
            ]);
        }

        return redirect()->route('cham-cong.index')->with('success', 'Cập nhật chấm công thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
