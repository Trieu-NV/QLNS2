<?php

namespace App\Http\Controllers;

use App\Models\PhongBan;
use Illuminate\Http\Request;

class PhongBanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PhongBan::query();
        
        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ten_phong_ban', 'like', "%{$search}%")
                  ->orWhere('mo_ta', 'like', "%{$search}%");
            });
        }
        
        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $phongBans = $query->withCount('nhanSu')->paginate(10);
        
        return view('phong-ban.index', compact('phongBans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('phong-ban.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_phong_ban' => 'required|string|max:255|unique:phong_ban,ten_phong_ban',
            'mo_ta' => 'nullable|string'
        ]);
        
        PhongBan::create($validated);
        
        return redirect()->route('phong-ban.index')->with('success', 'Thêm phòng ban thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PhongBan $phongBan)
    {
        $phongBan->load('nhanSu');
        return view('phong-ban.show', compact('phongBan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhongBan $phongBan)
    {
        return view('phong-ban.edit', compact('phongBan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhongBan $phongBan)
    {
        $validated = $request->validate([
            'ten_phong_ban' => 'required|string|max:255|unique:phong_ban,ten_phong_ban,' . $phongBan->id,
            'mo_ta' => 'nullable|string'
        ]);
        
        $phongBan->update($validated);
        
        return redirect()->route('phong-ban.index')->with('success', 'Cập nhật phòng ban thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhongBan $phongBan)
    {
        // Kiểm tra xem có nhân sự nào đang thuộc phòng ban này không
        if ($phongBan->nhanSu()->count() > 0) {
            return redirect()->route('phong-ban.index')->with('error', 'Không thể xóa phòng ban này vì đang có nhân sự!');
        }
        
        $phongBan->delete();
        
        return redirect()->route('phong-ban.index')->with('success', 'Xóa phòng ban thành công!');
    }
}
