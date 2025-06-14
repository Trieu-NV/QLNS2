<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Tìm kiếm
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('info', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('sdt', 'like', "%{$search}%");
            });
        }

        $danhSachUser = $query->paginate(10);
        return view('users.index', compact('danhSachUser'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'info' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'sdt' => 'required|string|max:20',
            'loaitk' => 'required|integer|in:0,1,2',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'info' => $request->info,
            'email' => $request->email,
            'sdt' => $request->sdt,
            'loaitk' => $request->loaitk,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Tài khoản đã được tạo thành công.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'info' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'sdt' => 'required|string|max:20',
            'loaitk' => 'required|integer|in:0,1,2',
        ]);

        $data = [
            'info' => $request->info,
            'email' => $request->email,
            'sdt' => $request->sdt,
            'loaitk' => $request->loaitk,
        ];

        // Cập nhật mật khẩu nếu được cung cấp
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:6',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Tài khoản đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Không cho phép xóa tài khoản admin cuối cùng
        if ($user->loaitk == 0 && User::where('loaitk', 0)->count() <= 1) {
            return redirect()->route('users.index')
                ->with('error', 'Không thể xóa tài khoản admin cuối cùng.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Tài khoản đã được xóa thành công.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'info' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'sdt' => 'required|string|max:20',
        ]);

        $user->update([
            'info' => $request->info,
            'email' => $request->email,
            'sdt' => $request->sdt,
        ]);

        return redirect()->route('user.profile')->with('success', 'Thông tin cá nhân đã được cập nhật.');
    }

    public function showChangePasswordForm()
    {
        return view('user.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.profile')->with('success', 'Mật khẩu đã được thay đổi.');
    }
}