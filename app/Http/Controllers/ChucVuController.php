<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ChucVu::query();
        
        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ten_chuc_vu', 'like', "%{$search}%")
                  ->orWhere('mo_ta', 'like', "%{$search}%");
            });
        }
        
        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $chucVus = $query->withCount('nhanSu')->paginate(10);
        
        return view('chuc-vu.index', compact('chucVus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chuc-vu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_chuc_vu' => 'required|string|max:255|unique:chuc_vu,ten_chuc_vu',
            'mo_ta' => 'nullable|string'
        ]);
        
        ChucVu::create($validated);
        
        return redirect()->route('chuc-vu.index')->with('success', 'Thêm chức vụ thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChucVu $chucVu)
    {
        $chucVu->load('nhanSu');
        return view('chuc-vu.show', compact('chucVu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChucVu $chucVu)
    {
        return view('chuc-vu.edit', compact('chucVu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChucVu $chucVu)
    {
        $validated = $request->validate([
            'ten_chuc_vu' => 'required|string|max:255|unique:chuc_vu,ten_chuc_vu,' . $chucVu->id,
            'mo_ta' => 'nullable|string'
        ]);
        
        $chucVu->update($validated);
        
        return redirect()->route('chuc-vu.index')->with('success', 'Cập nhật chức vụ thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChucVu $chucVu)
    {
        // Kiểm tra xem có nhân sự nào đang sử dụng chức vụ này không
        if ($chucVu->nhanSu()->count() > 0) {
            return redirect()->route('chuc-vu.index')->with('error', 'Không thể xóa chức vụ này vì đang có nhân sự sử dụng!');
        }
        
        $chucVu->delete();
        
        return redirect()->route('chuc-vu.index')->with('success', 'Xóa chức vụ thành công!');
    }
}
