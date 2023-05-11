<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;                   


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Roles/RoleIndex', [
            'roles' => RoleResource::collection(Role::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {

        return Inertia::render('Admin/Roles/Create', [
            'permissions' => PermissionResource::collection(Permission::all())
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);
        if($request->has('permissions')){
            $role->syncPermissions($request->input('permissions.*.name'));
        }
        
        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id): Response
    {
        $role = Role::findById($id);
        $role->load('permissions');

        return Inertia::render('Admin/Roles/Edite', [
            'role' => new RoleResource($role),
            'permissions' => PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateRoleRequest $request,string $id): RedirectResponse
    {
        $role = Role::findById($id);
        $role->update([
            'name' => $request->name
        ]);
        $role->syncPermissions($request->input('permissions.*.name'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $role = Role::findById($id);
        $role->delete();
        return back();
    }
}
