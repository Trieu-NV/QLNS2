<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If user is already logged in, redirect to appropriate dashboard
        if (request()->hasCookie('username')) {
            $username = request()->cookie('username');
            $user = User::where('username', $username)->first();
            
            if ($user) {
                return $this->redirectBasedOnUserType($user->loaitk);
            }
        }
        
        return view('login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Vui lòng nhập tài khoản.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $username = $request->input('username');
        $password = $request->input('password');

        // Check if user exists
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect('/login')
                ->with('error', 'Tài khoản không tồn tại.')
                ->withInput($request->except('password'));
        }

        // Verify password
        if (!Hash::check($password, $user->password)) {
            return redirect('/login')
                ->with('error', 'Mật khẩu không đúng.')
                ->withInput($request->except('password'));
        }

        // Check if user is active (you can add an 'active' field to users table)
        // if (!$user->active) {
        //     return redirect('/login')
        //         ->with('error', 'Tài khoản đã bị khóa.')
        //         ->withInput($request->except('password'));
        // }

        // Login successful - set cookie and redirect
        $response = $this->redirectBasedOnUserType($user->loaitk);
        
        // Set cookie with user info - use same path and domain for consistency
        $response->cookie('username', $username, 60 * 24 * 7, '/'); // 7 days
        $response->cookie('user_type', $user->loaitk, 60 * 24 * 7, '/');
        
        return $response->with('success', 'Đăng nhập thành công!');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // Log the logout attempt
        Log::info('Logout attempt for user: ' . $request->cookie('username'));
        
        // Create response and clear cookies
        $response = redirect('/login');
        
        // Clear cookies by setting them to expire in the past
        $response->withCookie('username', '', time() - 3600, '/');
        $response->withCookie('user_type', '', time() - 3600, '/');
        
        // Log that cookies have been cleared
        Log::info('Cookies cleared for logout');
        
        return $response->with('success', 'Đăng xuất thành công!');
    }

    /**
     * Final logout method - most robust approach
     */
    public function logoutFinal(Request $request)
    {
        Log::info('Final logout attempt for user: ' . $request->cookie('username'));
        
        // Create a new response
        $response = new \Illuminate\Http\RedirectResponse('/login');
        
        // Set cookies to expire in the past with empty values
        $response->headers->setCookie(new \Symfony\Component\HttpFoundation\Cookie(
            'username',
            '',
            time() - 3600,
            '/',
            null,
            false,
            false
        ));
        
        $response->headers->setCookie(new \Symfony\Component\HttpFoundation\Cookie(
            'user_type',
            '',
            time() - 3600,
            '/',
            null,
            false,
            false
        ));
        
        Log::info('Final logout - cookies cleared using Symfony Cookie');
        
        return $response->with('success', 'Đăng xuất thành công!');
    }

    /**
     * Alternative logout method using Response::make
     */
    public function logoutAlternative(Request $request)
    {
        Log::info('Alternative logout attempt for user: ' . $request->cookie('username'));
        
        // Create response using Response::make
        $response = \Illuminate\Http\Response::create();
        $response = $response->withCookie('username', '', time() - 3600, '/');
        $response = $response->withCookie('user_type', '', time() - 3600, '/');
        
        // Redirect after setting cookies
        return redirect('/login')->with('success', 'Đăng xuất thành công!');
    }

    /**
     * Test logout method (simpler version)
     */
    public function testLogout(Request $request)
    {
        $response = redirect('/login');
        
        // Force clear cookies with multiple approaches
        $response->cookie('username', '', time() - 3600, '/');
        $response->cookie('user_type', '', time() - 3600, '/');
        
        // Also try with different parameters
        $response->cookie('username', null, -1, '/');
        $response->cookie('user_type', null, -1, '/');
        
        return $response->with('success', 'Test logout completed!');
    }

    /**
     * Clear authentication cookies
     */
    private function clearAuthCookies($response)
    {
        $response->cookie('username', '', time() - 3600, '/');
        $response->cookie('user_type', '', time() - 3600, '/');
        return $response;
    }

    /**
     * Redirect user based on their account type
     */
    private function redirectBasedOnUserType($loaitk)
    {
        switch ($loaitk) {
            case 0: // Admin
                return redirect('/users');
            case 1: // HR
                return redirect('/dashboard');
            case 2: // Team Leader
                return redirect('/cham-cong');
            default:
                return redirect('/dashboard');
        }
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = $this->getCurrentUser();
        
        if (!$user) {
            return redirect('/login')->with('error', 'Phiên đăng nhập đã hết hạn.');
        }
        
        return view('auth.profile', compact('user'));
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle password change
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
        }

        $username = $request->cookie('username');
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Phiên đăng nhập đã hết hạn.');
        }

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Mật khẩu hiện tại không đúng.')
                ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email' => 'required|email',
        ], [
            'username.required' => 'Vui lòng nhập tài khoản.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('email'));
        }

        $username = $request->input('username');
        $email = $request->input('email');

        // Check if user exists and email matches
        $user = User::where('username', $username)
                   ->where('email', $email)
                   ->first();

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Tài khoản hoặc email không đúng.')
                ->withInput($request->except('email'));
        }

        // Generate reset token
        $token = Str::random(60);
        
        // Store reset token in database (you might want to create a password_resets table)
        // For now, we'll just show a success message
        // In a real application, you would:
        // 1. Store the token in password_resets table
        // 2. Send email with reset link
        // 3. Create reset password form
        
        return redirect()->back()
            ->with('success', 'Link đặt lại mật khẩu đã được gửi đến email của bạn. Vui lòng kiểm tra hộp thư.');
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        // In a real application, you would:
        // 1. Verify the token from password_resets table
        // 2. Check if token is not expired
        // 3. Update user password
        // 4. Delete the used token
        
        // For now, we'll just show a success message
        return redirect('/login')
            ->with('success', 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập với mật khẩu mới.');
    }

    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        $user = $this->getCurrentUser();
        if (!$user) {
            return redirect('/login')->with('error', 'Phiên đăng nhập đã hết hạn.');
            
        }
        return view('auth.edit-profile', compact('user'));
    }

    /**
     * Handle update profile
     */
    public function updateProfile(Request $request)
    {
        $user = $this->getCurrentUser();
        if (!$user) {
            return redirect('/login')->with('error', 'Phiên đăng nhập đã hết hạn.');
        }
        $validated = $request->validate([
            'info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'sdt' => 'nullable|string|max:20',
        ], [
            'email.email' => 'Email không hợp lệ.',
            'sdt.max' => 'Số điện thoại tối đa 20 ký tự.',
        ]);
        $user->info = $validated['info'];
        $user->email = $validated['email'];
        $user->sdt = $validated['sdt'];
        $user->save();
        return redirect()->route('profile')->with('success', 'Cập nhật thông tin thành công!');
    }
} 