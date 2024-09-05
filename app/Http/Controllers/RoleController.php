<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\RoleStoreRequest;

class RoleController extends Controller
{
    use BreadcrumbTrait;

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
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Role Create", "Roles", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        $role = new Role;

        $role->name = $request->name;

        $role->save();

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

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Role Edit", "Roles", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:roles,name,' . $id
        ]);

        $role = Role::find($id);
        if(!isset($role) || empty($role)) {
    		abort(404);
    	}

        $role->name = $request->name;

        $role->update();

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

        $role->delete();

        return redirect()->route('roles.index')
                         ->with('success', 'Role deleted successfully');
    }
}












