<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Permission;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\PermissionStoreRequest;
use App\Models\Group;

class PermissionController extends Controller
{
    use BreadcrumbTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Permissions List", "Permissions", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Group::all();
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Permission Create", "Permissions", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('permissions.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionStoreRequest $request)
    {
        $permission = new Permission;

        $permission->name = $request->name;
        $permission->group_id = $request->group_id;

        $permission->save();

        return redirect()->route('permissions.index')
                         ->with('success', 'New permission created successfully.');
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
        $permission = Permission::find($id);
        if(!isset($permission) || empty($permission)) {
    		abort(404);
    	}

        $groups = Group::all();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Permission Edit", "Permissions", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('permissions.edit', compact('permission', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:permissions,name,' . $id,
            'group_id' => 'required'
        ]);

        $permission = Permission::find($id);
        if(!isset($permission) || empty($permission)) {
    		abort(404);
    	}

        $permission->name = $request->name;
        $permission->group_id = $request->group_id;

        $permission->update();

        return redirect()->route('permissions.index')
                         ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        if(!isset($permission) || empty($permission)) {
    		abort(404);
    	}

        $permission->delete();

        return redirect()->route('permissions.index')
                         ->with('success', 'Permission deleted successfully');
    }
}
