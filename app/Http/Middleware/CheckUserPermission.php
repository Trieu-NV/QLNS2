<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $allowedTypes  Comma-separated list of allowed user types
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$allowedTypes)
    {
        if (!$request->hasCookie('username')) {
            return redirect()->route('login');
        }

        $username = $request->cookie('username');
        $user = DB::select('select * from users where username = ?', [$username]);
        
        if (empty($user)) {
            return redirect()->route('login');
        }

        $userType = $user[0]->loaitk;

        // Check if user type is in allowed types
        if (!in_array($userType, $allowedTypes)) {
            return redirect()->back();
        }

        return $next($request);
    }
} 