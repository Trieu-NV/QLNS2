<?php

namespace App\Http\Controllers;

use App\Models\BaoHiemYte;
use Illuminate\Http\Request;

class BaoHiemYteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BaoHiemYte::query();

        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('so_bao_hiem', 'like', "%{$search}%")
                  ->orWhere('noi_cap', 'like', "%{$search}%")
                  ->orWhere('noi_kham_benh', 'like', "%{$search}%");
            });
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'idbh');
        $sortOrder = $request->get('sort_order', 'asc');

        // Validate sort_by to prevent SQL injection
        $allowedSortColumns = ['idbh', 'so_bao_hiem', 'ngay_cap', 'noi_cap', 'noi_kham_benh'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'idbh'; // Default to a safe column
        }

        $query->orderBy($sortBy, $sortOrder);

        $baoHiemYtes = $query->paginate(10);

        return view('bao-hiem-yte.index', compact('baoHiemYtes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bao-hiem-yte.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idbh' => 'required|string|max:255|unique:bao_hiem_ytes,idbh',
            'ma_nv' => 'required|string|max:255',
            'so_bao_hiem' => 'required|string|max:10',
            'ngay_cap' => 'required|date',
            'noi_cap' => 'required|string|max:255',
            'noi_kham_benh' => 'required|string|max:255',
        ]);

        BaoHiemYte::create($validated);

        return redirect()->route('bao-hiem-yte.index')->with('success', 'Thêm bảo hiểm y tế thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BaoHiemYte $baoHiemYte)
    {
        return view('bao-hiem-yte.show', compact('baoHiemYte'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BaoHiemYte $baoHiemYte)
    {
        return view('bao-hiem-yte.edit', compact('baoHiemYte'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BaoHiemYte $baoHiemYte)
    {
        $validated = $request->validate([
            'idbh' => 'required|string|max:255|unique:bao_hiem_ytes,idbh,' . $baoHiemYte->idbh . ',idbh',
            'ma_nv' => 'required|string|max:255',
            'so_bao_hiem' => 'required|string|max:10',
            'ngay_cap' => 'required|date',
            'noi_cap' => 'required|string|max:255',
            'noi_kham_benh' => 'required|string|max:255',
        ]);

        $baoHiemYte->update($validated);

        return redirect()->route('bao-hiem-yte.index')->with('success', 'Cập nhật bảo hiểm y tế thành công!');
    }
 
    public function destroy(BaoHiemYte $baoHiemYte)
    {
        $baoHiemYte->delete();
        return redirect()->route('bao-hiem-yte.index')->with('success', 'Xóa bảo hiểm y tế thành công!');
    }
}