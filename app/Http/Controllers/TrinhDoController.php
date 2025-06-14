<?php

namespace App\Http\Controllers;

use App\Models\TrinhDo;
use Illuminate\Http\Request;

class TrinhDoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TrinhDo::query();
        
        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ten_trinh_do', 'like', "%{$search}%")
                  ->orWhere('mo_ta', 'like', "%{$search}%");
            });
        }
        
        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $trinhDos = $query->withCount('nhanSu')->paginate(10);
        
        return view('trinh-do.index', compact('trinhDos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trinh-do.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_trinh_do' => 'required|string|max:255|unique:trinh_do,ten_trinh_do',
            'mo_ta' => 'nullable|string'
        ]);
        
        TrinhDo::create($validated);
        
        return redirect()->route('trinh-do.index')->with('success', 'Thêm trình độ thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrinhDo $trinhDo)
    {
        $trinhDo->load('nhanSu');
        return view('trinh-do.show', compact('trinhDo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrinhDo $trinhDo)
    {
        return view('trinh-do.edit', compact('trinhDo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrinhDo $trinhDo)
    {
        $validated = $request->validate([
            'ten_trinh_do' => 'required|string|max:255|unique:trinh_do,ten_trinh_do,' . $trinhDo->id,
            'mo_ta' => 'nullable|string'
        ]);
        
        $trinhDo->update($validated);
        
        return redirect()->route('trinh-do.index')->with('success', 'Cập nhật trình độ thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrinhDo $trinhDo)
    {
        // Kiểm tra xem có nhân sự nào đang có trình độ này không
        if ($trinhDo->nhanSu()->count() > 0) {
            return redirect()->route('trinh-do.index')->with('error', 'Không thể xóa trình độ này vì đang có nhân sự sử dụng!');
        }
        
        $trinhDo->delete();
        
        return redirect()->route('trinh-do.index')->with('success', 'Xóa trình độ thành công!');
    }
}
