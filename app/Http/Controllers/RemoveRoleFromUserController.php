<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RemoveRoleFromUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user, Role $role): RedirectResponse
    {
        $user ->removeRole($role);
        return back();
    }
}
