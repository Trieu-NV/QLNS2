<?php

namespace App\Http\Controllers;

use App\Models\PhuCap;
use Illuminate\Http\Request;

class PhuCapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PhuCap::query();

        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('phu_cap_name', 'like', "%{$search}%")
                  ->orWhere('mo-ta', 'like', "%{$search}%");
            });
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'phu_cap_name');
        $sortOrder = $request->get('sort_order', 'asc');

        // Validate sort_by to prevent SQL injection
        $allowedSortColumns = ['phu_cap_name', 'so-tien', 'mo-ta'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'phu_cap_name'; // Default to a safe column
        }

        $query->orderBy($sortBy, $sortOrder);

        $phuCaps = $query->paginate(10);

        return view('phu-cap.index', compact('phuCaps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('phu-cap.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phu_cap_name' => 'required|string|max:255|unique:phu_cap,phu_cap_name',
            'so-tien' => 'required|numeric|min:0',
            'mo-ta' => 'nullable|string'
        ]);

        PhuCap::create($validated);

        return redirect()->route('phu-cap.index')->with('success', 'Thêm phụ cấp thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PhuCap $phuCap)
    {
        return view('phu-cap.show', compact('phuCap'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhuCap $phuCap)
    {
        return view('phu-cap.edit', compact('phuCap'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhuCap $phuCap)
    {
        $validated = $request->validate([
            'phu_cap_name' => 'required|string|max:255|unique:phu_cap,phu_cap_name,' . $phuCap->id,
            'so-tien' => 'required|numeric|min:0',
            'mo-ta' => 'nullable|string'
        ]);

        $phuCap->update($validated);

        return redirect()->route('phu-cap.index')->with('success', 'Cập nhật phụ cấp thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhuCap $phuCap)
    {
        $phuCap->delete();

        return redirect()->route('phu-cap.index')->with('success', 'Xóa phụ cấp thành công!');
    }
}
