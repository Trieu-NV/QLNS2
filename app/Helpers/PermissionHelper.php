<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PermissionHelper
{
    /**
     * Check if current user has permission to access specific user types
     */
    public static function hasPermission($allowedTypes)
    {
        $request = request();
        
        if (!$request->hasCookie('username')) {
            return false;
        }

        $username = $request->cookie('username');
        $user = DB::select('select * from users where username = ?', [$username]);
        
        if (empty($user)) {
            return false;
        }

        $userType = $user[0]->loaitk;

        if (is_string($allowedTypes)) {
            $allowedTypes = explode(',', $allowedTypes);
        }

        return in_array($userType, $allowedTypes);
    }

    /**
     * Get current user type
     */
    public static function getUserType()
    {
        $request = request();
        
        if (!$request->hasCookie('username')) {
            return null;
        }

        $username = $request->cookie('username');
        $user = DB::select('select * from users where username = ?', [$username]);
        
        if (empty($user)) {
            return null;
        }

        return $user[0]->loaitk;
    }

    /**
     * Get navigation items based on user type
     */
    public static function getNavigationItems()
    {
        $userType = self::getUserType();
        
        $allItems = [
            '0' => [ // Admin - Quản lý tài khoản user
                // ['route' => 'home', 'icon' => 'fa-solid fa-house', 'text' => 'Dashboard'],
                ['route' => 'users.index', 'icon' => 'fa-solid fa-users-cog', 'text' => 'Quản lý tài khoản'],
            ],
            '1' => [ // HR - Quản lý nhân sự, hợp đồng, lương, v.v.
                ['route' => 'home', 'icon' => 'fa-solid fa-house', 'text' => 'Dashboard'],
                ['route' => 'nhan-su.index', 'icon' => 'fa-solid fa-users', 'text' => 'Nhân Sự'],
                ['route' => 'luong', 'icon' => 'fa-solid fa-money-bill', 'text' => 'Lương'],
                ['route' => 'hop-dong.index', 'icon' => 'fa-solid fa-receipt', 'text' => 'Hợp Đồng'],
                ['route' => 'bao-hiem-yte.index', 'icon' => 'fa-solid fa-shield-halved', 'text' => 'Bảo Hiểm Y Tế'],
                ['route' => 'bao-hiem-xa-hoi.index', 'icon' => 'fa-solid fa-shield-halved', 'text' => 'Bảo Hiểm Xã Hội'],
                ['route' => 'phong-ban.index', 'icon' => 'fa-solid fa-building', 'text' => 'Phòng Ban'],
                ['route' => 'chuc-vu.index', 'icon' => 'fa-solid fa-crown', 'text' => 'Chức Vụ'],
                ['route' => 'trinh-do.index', 'icon' => 'fa-solid fa-graduation-cap', 'text' => 'Trình Độ'],
                ['route' => 'nhan-vien-phu-cap.index', 'icon' => 'fa-solid fa-hands-holding-child', 'text' => 'Phụ Cấp'],
            ],
            '2' => [ // Tổ trưởng - Quản lý chấm công và chuyên cần
                ['route' => 'cham-cong.index', 'icon' => 'fa-solid fa-calendar-days', 'text' => 'Chấm công'],
                ['route' => 'chuyen-can.index', 'icon' => 'fa-solid fa-star', 'text' => 'Chuyên Cần'],
            ],
        ];

        return $allItems[$userType] ?? [];
    }
} 