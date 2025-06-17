<?php

namespace App\Http\Controllers;

use App\Models\NhanSu;
use App\Models\ChucVu;
use App\Models\PhongBan;
use App\Models\TrinhDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Barryvdh\DomPDF\Facade\Pdf;

class NhanSuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = NhanSu::with(['chucVu', 'phongBan', 'trinhDo']);
        
        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ma_nv', 'like', "%{$search}%")
                  ->orWhere('ho_ten', 'like', "%{$search}%")
                  ->orWhere('sdt', 'like', "%{$search}%")
                  ->orWhere('dia_chi', 'like', "%{$search}%")
                  ->orWhereYear('ngay_sinh', 'like', "%{$search}%");
            });
        }
        
        // Lọc theo chức vụ
        if ($request->has('chuc_vu') && $request->chuc_vu) {
            $query->where('id_chuc_vu', $request->chuc_vu);
        }
        
        // Lọc theo phòng ban
        if ($request->has('phong_ban') && $request->phong_ban) {
            $query->where('id_phong_ban', $request->phong_ban);
        }
        
        // Lọc theo trình độ
        if ($request->has('trinh_do') && $request->trinh_do) {
            $query->where('id_trinh_do', $request->trinh_do);
        }

        // Lọc theo trạng thái
        $trangThai = $request->input('trang_thai', '1'); // Mặc định là '1' (Hoạt động)
        if ($trangThai !== null && $trangThai !== '') {
            $query->where('trang_thai', $trangThai);
        }
// Filter by birth date range
if ($request->has('ngay_sinh_from') && $request->ngay_sinh_from) {
    $query->whereDate('ngay_sinh', '>=', $request->ngay_sinh_from);
}

if ($request->has('ngay_sinh_to') && $request->ngay_sinh_to) {
    $query->whereDate('ngay_sinh', '<=', $request->ngay_sinh_to);
}

        // Lọc theo trạng thái
        if ($request->has('trang_thai') && $request->trang_thai !== null) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $nhanSu = $query->paginate(10);
        $chucVus = ChucVu::all();
        $phongBans = PhongBan::all();
        $trinhDos = TrinhDo::all();
        
        return view('nhan-su.index', compact('nhanSu', 'chucVus', 'phongBans', 'trinhDos'));
    }

    /**
     * Export personnel data to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = NhanSu::with(['chucVu', 'phongBan', 'trinhDo']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ma_nv', 'like', "%{$search}%")
                  ->orWhere('ho_ten', 'like', "%{$search}%")
                  ->orWhere('sdt', 'like', "%{$search}%")
                  ->orWhere('dia_chi', 'like', "%{$search}%");
            });
        }

        if ($request->has('chuc_vu') && $request->chuc_vu) {
            $query->where('id_chuc_vu', $request->chuc_vu);
        }

        if ($request->has('phong_ban') && $request->phong_ban) {
            $query->where('id_phong_ban', $request->phong_ban);
        }

        if ($request->has('trinh_do') && $request->trinh_do) {
            $query->where('id_trinh_do', $request->trinh_do);
        }
        
        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $nhanSus = $query->get();
        
        return Pdf::loadView('nhan-su.nhan-su', compact('nhanSus'))
                    ->setPaper('a4', 'landscape')
                    ->stream('nhan-su.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $chucVus = ChucVu::all();
        $phongBans = PhongBan::all();
        $trinhDos = TrinhDo::all();
        
        return view('nhan-su.create', compact('chucVus', 'phongBans', 'trinhDos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_nv' => 'required|string|unique:nhan_su,ma_nv',
            'ho_ten' => 'required|string|max:255',
            'gioi_tinh' => 'required|in:Nam,Nữ,Khác',
            'ngay_sinh' => 'required|date',
            'sdt' => 'nullable|string|max:15',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
            'dia_chi' => 'nullable|string',
            'id_chuc_vu' => 'required|exists:chuc_vu,id',
            'id_phong_ban' => 'required|exists:phong_ban,id',
            'id_trinh_do' => 'required|exists:trinh_do,id',
            'trang_thai' => 'required|boolean'
        ]);
        
        if ($request->hasFile('hinh_anh')) {
            $validated['hinh_anh'] = $request->file('hinh_anh')->store('nhan-su', 'public');
        }
        
        NhanSu::create($validated);
        
        return redirect()->route('nhan-su.index')->with('success', 'Thêm nhân sự thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(NhanSu $nhanSu)
    {
        $nhanSu->load(['chucVu', 'phongBan', 'trinhDo']);
        return view('nhan-su.show', compact('nhanSu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NhanSu $nhanSu)
    {
        $chucVus = ChucVu::all();
        $phongBans = PhongBan::all();
        $trinhDos = TrinhDo::all();
        
        return view('nhan-su.edit', compact('nhanSu', 'chucVus', 'phongBans', 'trinhDos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NhanSu $nhanSu)
    {
        $validated = $request->validate([
            'ma_nv' => 'required|string|unique:nhan_su,ma_nv,' . $nhanSu->ma_nv . ',ma_nv',
            'ho_ten' => 'required|string|max:255',
            'gioi_tinh' => 'required|in:Nam,Nữ,Khác',
            'ngay_sinh' => 'required|date',
            'sdt' => 'nullable|string|max:15',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dia_chi' => 'nullable|string',
            'id_chuc_vu' => 'required|exists:chuc_vu,id',
            'id_phong_ban' => 'required|exists:phong_ban,id',
            'id_trinh_do' => 'required|exists:trinh_do,id',
            'trang_thai' => 'required|boolean'
        ]);
        
        if ($request->hasFile('hinh_anh')) {
            // Xóa ảnh cũ
            if ($nhanSu->hinh_anh) {
                Storage::disk('public')->delete($nhanSu->hinh_anh);
            }
            $validated['hinh_anh'] = $request->file('hinh_anh')->store('nhan-su', 'public');
        }
        
        $nhanSu->update($validated);
        
        return redirect()->route('nhan-su.index')->with('success', 'Cập nhật nhân sự thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NhanSu $nhanSu)
    {
        // Xóa ảnh nếu có
        if ($nhanSu->hinh_anh) {
            Storage::disk('public')->delete($nhanSu->hinh_anh);
        }
        
        $nhanSu->delete();
        
        return redirect()->route('nhan-su.index')->with('success', 'Xóa nhân sự thành công!');
    }

    /**
     * Export personnel data to Excel
     */
    public function exportExcel(Request $request)
    {
        // Tạo query tương tự như trong index method
        $query = NhanSu::with(['chucVu', 'phongBan', 'trinhDo']);
        
        // Áp dụng các bộ lọc từ request
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ma_nv', 'like', "%{$search}%")
                  ->orWhere('ho_ten', 'like', "%{$search}%")
                  ->orWhere('sdt', 'like', "%{$search}%")
                  ->orWhere('dia_chi', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('chuc_vu') && $request->chuc_vu) {
            $query->where('id_chuc_vu', $request->chuc_vu);
        }
        
        if ($request->has('phong_ban') && $request->phong_ban) {
            $query->where('id_phong_ban', $request->phong_ban);
        }
        
        if ($request->has('trinh_do') && $request->trinh_do) {
            $query->where('id_trinh_do', $request->trinh_do);
        }
        
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $nhanSu = $query->get();
        
        // Tạo spreadsheet mới
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Thiết lập tiêu đề
        $sheet->setTitle('Danh sách nhân sự');
        
        // Thiết lập header
        $headers = [
            'A1' => 'STT',
            'B1' => 'Mã NV',
            'C1' => 'Họ tên',
            'D1' => 'Giới tính',
            'E1' => 'Ngày sinh',
            'F1' => 'Số điện thoại',
            'G1' => 'Địa chỉ',
            'H1' => 'Chức vụ',
            'I1' => 'Phòng ban',
            'J1' => 'Trình độ',
            'K1' => 'Trạng thái'
        ];
        
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        
        // Định dạng header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ];
        
        $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);
        
        // Thêm dữ liệu
        $row = 2;
        foreach ($nhanSu as $index => $ns) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $ns->ma_nv);
            $sheet->setCellValue('C' . $row, $ns->ho_ten);
            $sheet->setCellValue('D' . $row, $ns->gioi_tinh);
            $sheet->setCellValue('E' . $row, $ns->ngay_sinh ? $ns->ngay_sinh->format('d/m/Y') : '');
            $sheet->setCellValue('F' . $row, $ns->sdt);
            $sheet->setCellValue('G' . $row, $ns->dia_chi);
            $sheet->setCellValue('H' . $row, $ns->chucVu ? $ns->chucVu->ten_chuc_vu : '');
            $sheet->setCellValue('I' . $row, $ns->phongBan ? $ns->phongBan->ten_phong_ban : '');
            $sheet->setCellValue('J' . $row, $ns->trinhDo ? $ns->trinhDo->ten_trinh_do : '');
            $sheet->setCellValue('K' . $row, $ns->trang_thai ? 'Hoạt động' : 'Không hoạt động');
            $row++;
        }
        
        // Định dạng dữ liệu
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];
        
        $sheet->getStyle('A1:K' . ($row - 1))->applyFromArray($dataStyle);
        
        // Tự động điều chỉnh độ rộng cột
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Tạo tên file
        $fileName = 'danh-sach-nhan-su-' . date('Y-m-d-H-i-s') . '.xlsx';
        
        // Tạo writer và xuất file
        $writer = new Xlsx($spreadsheet);
        
        // Thiết lập headers cho download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}
