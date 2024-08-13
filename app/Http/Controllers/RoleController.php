<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Traits\BreadcrumbTrait;
use App\Traits\PermissionTrait;
use App\Http\Requests\RoleStoreRequest;

class RoleController extends Controller
{
    use BreadcrumbTrait, PermissionTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::get();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Roles List", "Roles", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all permissions
        $permissionArray = $this->getPermissions();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Role Create", "Roles", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('roles.create', compact('permissionArray'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        $role = new Role;

        $role->name = $request->name;

        $role->save();

        $role->permissions()->sync($request->permission_id);

        return redirect()->route('roles.index')
                         ->with('success', 'New role created successfully.');        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        if(!isset($role) || empty($role)) {
    		abort(404);
    	}

        $rolePermissions = [];
         // get all permissions
        $permissionArray = $this->getPermissions();
        // get role permissions
        if(count($role->permissions) > 0) {
            foreach($role->permissions as $perm) {
                $rolePermissions[] = $perm->id;
            }
        }

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Role Edit", "Roles", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('roles.edit', compact('role', 'permissionArray', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:roles,name,' . $id,
            'permission_id' => 'required|array|min:1'
        ]);

        $role = Role::find($id);
        if(!isset($role) || empty($role)) {
    		abort(404);
    	}

        $role->name = $request->name;

        $role->update();

        $role->permissions()->sync($request->permission_id);

        return redirect()->route('roles.index')
                         ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        if(!isset($role) || empty($role)) {
    		abort(404);
    	}

        $role->permissions()->delete();
        $role->delete();
    //    $role->permissions()->detach();

        return redirect()->route('roles.index')
                         ->with('success', 'Role deleted successfully');
    }
}












