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
        $loaiHopDong = $request->get('loai_hop_dong');
        $ngayBatDau = $request->get('ngay_bat_dau');
        $ngayKetThuc = $request->get('ngay_ket_thuc');
        $trangThai = $request->get('trang_thai');
        $sort = $request->get('sort');
        
        $hopDongs = HopDong::with('nhanSu')
            ->when($search, function($query) use ($search) {
                $query->whereHas('nhanSu', function($q) use ($search) {
                    $q->where('ho_ten', 'like', "%{$search}%")
                      ->orWhere('ma_nv', 'like', "%{$search}%");
                });
            })
            ->when($loaiHopDong, function($query) use ($loaiHopDong) {
                $query->where('loai_hop_dong', $loaiHopDong);
            })
            ->when($ngayBatDau, function($query) use ($ngayBatDau) {
                $query->whereDate('ngay_bat_dau', '>=', $ngayBatDau);
            })
            ->when($ngayKetThuc, function($query) use ($ngayKetThuc) {
                $query->whereDate('ngay_ket_thuc', '<=', $ngayKetThuc);
            })
            ->when($trangThai !== null && $trangThai !== '', function($query) use ($trangThai) {
                $query->whereHas('nhanSu', function($q) use ($trangThai) {
                    $q->where('trang_thai', $trangThai);
                });
            })
            ->when($sort === 'luong_asc', function($query) {
                $query->orderBy('luong', 'asc');
            })
            ->when($sort === 'luong_desc', function($query) {
                $query->orderBy('luong', 'desc');
            })
            ->when(!$sort || ($sort !== 'luong_asc' && $sort !== 'luong_desc'), function($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->paginate(10)
            ->appends($request->except('page'));

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
            'ngay_ket_thuc' => 'nullable|date_format:d/m/Y',
            'ngay_ky' => 'required|date_format:d/m/Y',
        ]);

        // Convert dates to Carbon objects for comparison
        $ngayKy = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['ngay_ky']);
        $ngayBatDau = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['ngay_bat_dau']);
        
        // Check if employee has previous contracts
        $previousContract = HopDong::where('ma_nv', $validated['ma_nv'])
                                  ->orderBy('so_lan_ky', 'desc')
                                  ->first();
        
        if ($previousContract) {
            if ($previousContract->ngay_ket_thuc) {
                // If previous contract has end date, new contract signing date must be after previous contract end date
                $previousEndDate = \Carbon\Carbon::parse($previousContract->ngay_ket_thuc);
                if ($ngayKy <= $previousEndDate) {
                    return back()
                        ->withInput()
                        ->withErrors(['ngay_ky' => 'Ngày ký hợp đồng mới phải sau ngày kết thúc của hợp đồng trước đó (' . $previousEndDate->format('d/m/Y') . ').']);
                }
            } else {
                // If previous contract has no end date (indefinite), new contract signing date must be after previous contract start date
                $previousStartDate = \Carbon\Carbon::parse($previousContract->ngay_bat_dau);
                if ($ngayKy <= $previousStartDate) {
                    return back()
                        ->withInput()
                        ->withErrors(['ngay_ky' => 'Ngày ký hợp đồng mới phải sau ngày bắt đầu của hợp đồng trước đó (' . $previousStartDate->format('d/m/Y') . ').']);
                }
            }
        }
        
        // Validation logic based on contract type
        if ($validated['loai_hop_dong'] == 1) {
            // Loại có thời hạn: ngày ký < ngày bắt đầu < ngày kết thúc
            if (!$request->ngay_ket_thuc) {
                return back()
                    ->withInput()
                    ->withErrors(['ngay_ket_thuc' => 'Hợp đồng có thời hạn phải có ngày kết thúc.']);
            }
            
            $ngayKetThuc = \Carbon\Carbon::createFromFormat('d/m/Y', $request->ngay_ket_thuc);
            
            if ($ngayKy >= $ngayBatDau) {
                return back()
                    ->withInput()
                    ->withErrors(['ngay_ky' => 'Ngày ký phải trước ngày bắt đầu.']);
            }
            
            if ($ngayBatDau >= $ngayKetThuc) {
                return back()
                    ->withInput()
                    ->withErrors(['ngay_bat_dau' => 'Ngày bắt đầu phải trước ngày kết thúc.']);
            }
            
            $validated['ngay_ket_thuc'] = $ngayKetThuc->format('Y-m-d');
        } else {
            // Loại không thời hạn: ngày ký < ngày bắt đầu
            if ($ngayKy >= $ngayBatDau) {
                return back()
                    ->withInput()
                    ->withErrors(['ngay_ky' => 'Ngày ký phải trước ngày bắt đầu.']);
            }
            
            $validated['ngay_ket_thuc'] = null;
        }

        // Convert dates to 'Y-m-d' format for database storage
        $validated['ngay_bat_dau'] = $ngayBatDau->format('Y-m-d');
        $validated['ngay_ky'] = $ngayKy->format('Y-m-d');

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
            Log::error('Error creating hop dong: ' . $e->getMessage());
            
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
    public function update(Request $request, $id)
    {
        $hopDong = HopDong::findOrFail($id);

        $validated = $request->validate([
            'ma_nv' => 'required|exists:nhan_su,ma_nv',
            'loai_hop_dong' => 'required|integer|between:1,2',
            'luong' => 'required|numeric|min:0',
            'ngay_bat_dau' => 'required|date_format:d/m/Y',
            'ngay_ket_thuc' => 'nullable|date_format:d/m/Y',
            'ngay_ky' => 'required|date_format:d/m/Y',
        ]);

        // Convert dates to Carbon objects for comparison
        $ngayKy = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['ngay_ky']);
        $ngayBatDau = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['ngay_bat_dau']);
        
        // Check if employee has previous contracts (excluding current contract being updated)
        $previousContract = HopDong::where('ma_nv', $validated['ma_nv'])
                                  ->where('id', '!=', $id)
                                  ->orderBy('so_lan_ky', 'desc')
                                  ->first();
        
        if ($previousContract) {
            if ($previousContract->ngay_ket_thuc) {
                // If previous contract has end date, updated contract signing date must be after previous contract end date
                $previousEndDate = \Carbon\Carbon::parse($previousContract->ngay_ket_thuc);
                if ($ngayKy <= $previousEndDate) {
                    return back()
                        ->withInput()
                        ->withErrors(['ngay_ky' => 'Ngày ký hợp đồng phải sau ngày kết thúc của hợp đồng trước đó (' . $previousEndDate->format('d/m/Y') . ').']);
                }
            } else {
                // If previous contract has no end date (indefinite), updated contract signing date must be after previous contract start date
                $previousStartDate = \Carbon\Carbon::parse($previousContract->ngay_bat_dau);
                if ($ngayKy <= $previousStartDate) {
                    return back()
                        ->withInput()
                        ->withErrors(['ngay_ky' => 'Ngày ký hợp đồng phải sau ngày bắt đầu của hợp đồng trước đó (' . $previousStartDate->format('d/m/Y') . ').']);
                }
            }
        }
        
        // Validation logic based on contract type
        if ($validated['loai_hop_dong'] == 1) {
            // Loại có thời hạn: ngày ký < ngày bắt đầu < ngày kết thúc
            if (!$request->ngay_ket_thuc) {
                return back()
                    ->withInput()
                    ->withErrors(['ngay_ket_thuc' => 'Hợp đồng có thời hạn phải có ngày kết thúc.']);
            }
            
            $ngayKetThuc = \Carbon\Carbon::createFromFormat('d/m/Y', $request->ngay_ket_thuc);
            
            if ($ngayKy >= $ngayBatDau) {
                return back()
                    ->withInput()
                    ->withErrors(['ngay_ky' => 'Ngày ký phải trước ngày bắt đầu.']);
            }
            
            if ($ngayBatDau >= $ngayKetThuc) {
                return back()
                    ->withInput()
                    ->withErrors(['ngay_bat_dau' => 'Ngày bắt đầu phải trước ngày kết thúc.']);
            }
            
            $validated['ngay_ket_thuc'] = $ngayKetThuc->format('Y-m-d');
        } else {
            // Loại không thời hạn: ngày ký < ngày bắt đầu
            if ($ngayKy >= $ngayBatDau) {
                return back()
                    ->withInput()
                    ->withErrors(['ngay_ky' => 'Ngày ký phải trước ngày bắt đầu.']);
            }
            
            $validated['ngay_ket_thuc'] = null;
        }

        // Convert dates to 'Y-m-d' format for database storage
        $validated['ngay_bat_dau'] = $ngayBatDau->format('Y-m-d');
        $validated['ngay_ky'] = $ngayKy->format('Y-m-d');

        try {
            DB::beginTransaction();

            $hopDong->update($validated);

            DB::commit();

            return redirect()->route('hop-dong.index')->with('success', 'Cập nhật hợp đồng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the exception for debugging
            Log::error('Error updating hop dong: ' . $e->getMessage());
            
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
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
