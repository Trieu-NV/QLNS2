<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckUsernameCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to login and forgot password pages
        if (in_array($request->path(), ['login', 'forgot-password'])) {
            return $next($request);
        }

        // Check if user has valid cookie
        if (!$request->hasCookie('username')) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $username = $request->cookie('username');
        
        // Verify user exists in database
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            // Clear invalid cookie and redirect to login
            $response = redirect('/login')->with('error', 'Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại.');
            $response = $this->clearAuthCookies($response);
            return $response;
        }

        // Add user info to request for use in controllers
        $request->attributes->set('current_user', $user);
        
        return $next($request);
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
}