<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Http\Controllers\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;
use Inertia\Response;
class HomeController extends Controller
{
    public function index(): response
    {
        $user= Auth::user();
        if( $user->hasRole('admin')) {
            return Inertia::render('UserView');
        }elseif($user->hasRole('moderator')) {
            return Inertia::render('UserView');
        
        }elseif($user->hasRole('writer')) {
            return Inertia::render('UserView');
        
        }else {
            return Inertia::render('Dashboard');
        }
    }
}
