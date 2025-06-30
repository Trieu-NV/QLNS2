<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get the current authenticated user
     */
    protected function getCurrentUser(): ?User
    {
        return request()->attributes->get('current_user');
    }

    /**
     * Get the current user's account type
     */
    protected function getCurrentUserType(): ?int
    {
        $user = $this->getCurrentUser();
        return $user ? $user->loaitk : null;
    }
}