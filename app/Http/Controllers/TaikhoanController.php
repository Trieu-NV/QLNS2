<?php

namespace App\Http\Controllers;

use App\Models\Taikhoan; 
use Illuminate\Http\Request;

class TaikhoanController extends Controller
{
   //get danh sách tài khoản
    public function index()
    {
        // $danhSachTaiKhoan = Taikhoan::all();
        return view('taikhoan.index');
            // ->with('i', 0); // Khởi tạo i = 0
    }
    //lấy form thêm . GET
    public function create()
    {
        
        return view('taikhoan.create');
    }
    //Xử lý thêm tài khoản. POST
    public function store(Request $request)
    {
return redirect()->route('taikhoan')
            ->with('success', 'Account created successfully');
    }
    //Lấy thông tin 1 tài khoản. GET
    public function show(string $id)
    {
        //
    }

    //Lấy form sửa tài khoản. GET
    public function edit(string $id)
    {
        //
    }

    //Xử lý sửa tài khoản. PUT
    public function update(Request $request, string $id)
    {
        //
    }

    //Xóa tài khoản. DELETE
    public function destroy(string $id)
    {
        //
    }
}
