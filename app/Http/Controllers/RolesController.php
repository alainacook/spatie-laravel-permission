<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public static function setRoles() {
        // Getting roles
        $adminRole = Role::findOrCreate('admin');
        $generalRole = Role::findOrCreate('general');

        // Creating permissions
        Permission::findOrCreate('edit');
        Permission::findOrCreate('create');
        Permission::findOrCreate('view');

        // Assigning permissions to roles
        $adminRole -> givePermissionTo('edit');
        $adminRole -> givePermissionTo('create');
        $adminRole -> givePermissionTo('view');

        $generalRole -> givePermissionTo('view');
    }

    public static function getViewForRole($role): View {
        $roleFromStore = Role::findByName($role);

        $roleName = $roleFromStore->attributesToArray()['name'];

        if ($roleFromStore -> hasPermissionTo('create')) {
            return view("can-create", ['roleName' => $roleName]);
        } else {
            return view("can-view", ['roleName' => $roleName]);
        }
    }
}
