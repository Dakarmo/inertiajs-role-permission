<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Http\Resources\RoleResource;
use PHPUnit\Framework\Constraint\IsEmpty;
use Spatie\Permission\Models\Role;
use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {    
        
    // if($request->input('term') !== null){
           
    //     // dd($request->input('term')['_value']);
    //     $search=$request->input('term')['_value'];
    //     $users = User::where('name', 'LIKE', '%'.$search.'%')->paginate(10);
    //     return Inertia::render('Admin/Users/UserIndex', [
    //         'users' => $users
    //     ]);
    //  }else {
         $users = User::paginate(10);
        //  $users = User::All();
         // $users = User::where('id', '>', 8)->get();
        //  dd($users);
         return Inertia::render('Admin/Users/UserIndex', [
                 'users' => $users 
             ]);
    //  }
    }

  


    








    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Users/Create', [
            'roles' => RoleResource::collection(Role::all()),
            'permissions' => PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

          $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
         $user ->syncRoles($request->input('roles.*.name'));
         $user ->syncPermissions($request->input('permissions.*.name'));
        return redirect(route('users.index'));
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
    public function edit(User $user): Response
    {
        $user->load(['roles', 'permissions']);
        return Inertia::render('Admin/Users/Edite', [
            'user' => new UserResource($user),
            'roles' => RoleResource::collection(Role::all()),
            'permissions' => PermissionResource::collection(Permission::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|'. Rule::unique('users','email')->ignore($user),
            'roles' => ['sometimes', 'array'],
            'permissions' => ['sometimes', 'array'],
            
        ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user ->syncRoles($request->input('roles.*.name'));
            $user ->syncPermissions($request->input('permissions.*.name'));
    
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect(route('users.index'))->with('message', 'Utilisateur supprimé avec succès');
    }

    public function search (Request $request){       

        // $req =  DB::select('SELECT *
        // FROM users
        // WHERE `name` LIKE \'%'.$request->name.'%\'');

    
            $req = User::where('name', 'like', '%' . $request->name . '%')
            ->paginate(10);

            $data = [     
            
                'users'=>$req,
            ];
            return response()->json($data,200);

       

}
}
