<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RevokePermissionFromRoleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Role $role, Permission $permission): RedirectResponse
    {
        $role ->revokePermissionTo($permission);
        return back();
    }
}
