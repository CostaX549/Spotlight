<?php

namespace App\Policies;

use App\Models\User;

class AdminAccessPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewAdminDashboard(User $user)
{
    return $user->isAdmin();
}
}
