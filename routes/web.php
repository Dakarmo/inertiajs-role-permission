<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RemovePermissionFromUserController;
use App\Http\Controllers\RemoveRoleFromUserController;
use App\Http\Controllers\RevokePermissionFromRoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCsvController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Safety\CryptageData;
use App\Safety\DecryptageData;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/cryptage', function () {

    $show = "function de cryptage";
    $texte1 = CryptageData::datacrypt($show);

    $texte2 = DecryptageData::datadecrypt($texte1);


    return Inertia::render('Cryptage', [
        "texte" => $texte1,
        "decry" => $texte2
    ]);
});

// Route::get('/decryptage', function () {

//     $texte = "function de cryptage"
//     return Inertia::render('Cryptage', [
//         "texte" => $texte
//     ]);
// })


Route::get('/home', [HomeController::class, 'index']);

Route::resource('/users', UserController::class);
Route::post('/usersSearch', [UserCsvController::class,'search']);


Route::resource('/roles', RoleController::class);
Route::resource('/posts', PostController::class);

Route::delete('/posts/{id}', [PostController::class, 'destroy']);

Route::resource('/permissions', PermissionController::class);

Route::delete('/roles/{role}/permissions/{permission}', RevokePermissionFromRoleController::class)
    ->name('roles.permissions.destroy');
Route::delete('/users/{user}/permissions/{permission}', RemovePermissionFromUserController::class)
    ->name('users.permissions.destroy');
Route::delete('/users/{user}/roles/{role}', RemoveRoleFromUserController::class)
    ->name('users.roles.destroy');
    
    Route::post('/usercsv', [UserCsvController::class, 'fileImport'])->name('file-import');
    Route::get('/usercsv', [UserCsvController::class, 'fileExport'])->name('file-export');
    Route::get('/usercs', [UserCsvController::class, 'create'])->name('usercsv.create');
    Route::get('/usercsv', [UserCsvController::class, 'index'])->name('usercsv.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Route::resource('/usercsv', UserCsvController::class);

Route::inertia('/error/{status}', 'ErrorPage')->name('error');
// Route::get('/error/{status}', [ErrorController::class, 'showError'])->name('error');




Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    
});



require __DIR__.'/auth.php';
