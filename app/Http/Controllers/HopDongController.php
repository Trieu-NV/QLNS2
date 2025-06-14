<?php

namespace App\Http\Controllers;

use App\Models\HopDong;
use App\Models\NhanSu;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HopDongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $hopDongs = HopDong::with('nhanSu')
            ->when($search, function($query) use ($search) {
                $query->whereHas('nhanSu', function($q) use ($search) {
                    $q->where('ho_ten', 'like', "%{$search}%")
                      ->orWhere('ma_nv', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('hop-dong.index', compact('hopDongs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nhanSu = NhanSu::where('trang_thai', 1)->get();
        return view('hop-dong.create', compact('nhanSu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_nv' => 'required|exists:nhan_su,ma_nv',
            'loai_hop_dong' => 'required|integer|between:1,2',
            'luong' => 'required|numeric|min:0',
            'ngay_bat_dau' => 'required|date_format:d/m/Y',
            'ngay_ket_thuc' => 'nullable|date_format:d/m/Y|after:ngay_bat_dau_formatted',
            'ngay_ky' => 'required|date_format:d/m/Y',
        ]);

        // Conditionally make ngay_ket_thuc required
        if ($validated['loai_hop_dong'] == 1) {
            $validated['ngay_ket_thuc'] = $request->validate([
                'ngay_ket_thuc' => 'required|date_format:d/m/Y|after:ngay_bat_dau_formatted',
            ])['ngay_ket_thuc'];
        } else {
            $validated['ngay_ket_thuc'] = null; // Set to null if not required
        }

        // Convert dates to 'Y-m-d' format for database storage
        $validated['ngay_bat_dau'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['ngay_bat_dau'])->format('Y-m-d');
        if ($validated['ngay_ket_thuc']) {
            $validated['ngay_ket_thuc'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['ngay_ket_thuc'])->format('Y-m-d');
        }
        $validated['ngay_ky'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['ngay_ky'])->format('Y-m-d');

        try {
            DB::beginTransaction();
            
            $latestHopDong = HopDong::where('ma_nv', $validated['ma_nv'])
                                    ->orderBy('so_lan_ky', 'desc')
                                    ->first();

            $soLanKy = $latestHopDong ? $latestHopDong->so_lan_ky + 1 : 1;
            $validated['so_lan_ky'] = $soLanKy;

            $hopDong = HopDong::create($validated);
            
            DB::commit();
            return redirect()
                ->route('hop-dong.index')
                ->with('success', 'Thêm hợp đồng thành công');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the exception for debugging
            
            
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HopDong $hopDong)
    {
        $hopDong->load('nhanSu');
        return view('hop-dong.show', compact('hopDong'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HopDong $hopDong)
    {
        $nhanSu = NhanSu::all();
        return view('hop-dong.edit', compact('hopDong', 'nhanSu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HopDong $hopDong)
    {
        $validated = $request->validate([
            'ma_nv' => 'required|exists:nhan_su,ma_nv',
            'loai_hop_dong' => 'required|integer|between:1,2',
            'luong' => 'required|numeric|min:0',
            'ngay_bat_dau' => 'required|date_format:d/m/Y',
            'ngay_ket_thuc' => 'nullable|date_format:d/m/Y|after:ngay_bat_dau_formatted',
            'ngay_ky' => 'required|date_format:d/m/Y',
        ]);

        // Conditionally make ngay_ket_thuc required
        if ($validated['loai_hop_dong'] == 1) {
            $validated['ngay_ket_thuc'] = $request->validate([
                'ngay_ket_thuc' => 'required|date_format:d/m/Y|after:ngay_bat_dau_formatted',
            ])['ngay_ket_thuc'];
        } else {
            $validated['ngay_ket_thuc'] = null; // Set to null if not required
        }

        // Convert dates to 'Y-m-d' format for database storage
        $validated['ngay_bat_dau'] = Carbon::createFromFormat('d/m/Y', $validated['ngay_bat_dau'])->format('Y-m-d');
        if ($validated['ngay_ket_thuc']) {
            $validated['ngay_ket_thuc'] = Carbon::createFromFormat('d/m/Y', $validated['ngay_ket_thuc'])->format('Y-m-d');
        }
        $validated['ngay_ky'] = Carbon::createFromFormat('d/m/Y', $validated['ngay_ky'])->format('Y-m-d');


        try {
            DB::beginTransaction();
            
            $hopDong->update($validated);
            
            DB::commit();
            return redirect()
                ->route('hop-dong.index')
                ->with('success', 'Cập nhật hợp đồng thành công');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HopDong $hopDong)
    {
        try {
            DB::beginTransaction();
            
            $hopDong->delete();
            
            DB::commit();
            return redirect()
                ->route('hop-dong.index')
                ->with('success', 'Xóa hợp đồng thành công');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
