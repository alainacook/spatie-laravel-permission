<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\RolesController;

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
    return view('welcome');
});

Route::get("/check-role/{userName}", function(String $userName) {
    RolesController::setRoles();

    $allUsers = User::all();

    $selectedUser = $allUsers -> filter(function($item) use ($userName) {
        return $item -> name == $userName;
    }) -> first();

    return RolesController::getViewForRole($selectedUser);
});
