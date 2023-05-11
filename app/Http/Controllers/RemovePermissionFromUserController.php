<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RemovePermissionFromUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user, Permission $permission): RedirectResponse
    {
        $user ->revokePermissionTo($permission);
        return back();
    }
}
