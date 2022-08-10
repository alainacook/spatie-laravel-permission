<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public static function setRoles() {
        $allUsers = User::all();

        $generalUser = $allUsers -> filter(function($item) {
            return $item -> name == 'MyUsername';
        }) -> first();

        $adminUser = $allUsers -> filter(function($item) {
            return $item -> name == 'administrator';
        }) -> first();

        $generalUser -> removeRole('admin');
        $generalUser -> removeRole('admin');

        $adminUser -> removeRole('general');
        $adminUser -> removeRole('general');

        // Getting roles
        $adminRole = Role::findOrCreate('admin');
        $generalRole = Role::findOrCreate('general');

        // Creating permissions
        $editPerm = Permission::findOrCreate('edit');
        $createPerm = Permission::findOrCreate('create');
        $viewPerm = Permission::findOrCreate('view');

        // Assigning permissions to roles
        $adminRole -> givePermissionTo($editPerm, $createPerm, $viewPerm);

        $generalRole -> givePermissionTo($viewPerm);

        $generalUser -> assignRole($generalRole);

        $adminUser -> assignRole($adminRole);
    }

    public static function getViewForRole(User $user): View {
        $userRoles = $user -> roles();

        $roleFromStore = $userRoles -> first();

        $view = 'no-permission';
        $roleName = 'No role';

        if ($roleFromStore != null) {

            $roleName = $roleFromStore->attributesToArray()['name'];

            if ($roleFromStore->hasPermissionTo('create')) {
                $view = 'can-create';
            } elseif ($roleFromStore->hasPermissionTo('view')) {
                $view = 'can-view';
            }
        }

        return view($view)
            ->with('roleName', $roleName)
            ->with('userName', $user['name']);
    }
}
