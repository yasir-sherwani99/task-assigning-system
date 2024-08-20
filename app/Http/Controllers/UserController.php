<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRolePermissionsUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

use Image;

use App\Models\User;
use App\Models\Role;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Traits\ImageTrait;
use App\Traits\PermissionTrait;

class UserController extends Controller
{
    use BreadcrumbTrait, PermissionTrait, ImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Users List", "Users", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('users.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function getUsers()
    {
        $userArray = [];
        $users = User::with('roles')->sort('desc')->get();
        
        if(count($users) > 0) {
            foreach($users as $user) {
                $userRoles = "";
                $userName = "<img src=\"{$user->photo}\" alt=\"{$user->first_name}\" class=\"rounded-circle thumb-sm me-2\" />" . $user->first_name . ' ' . $user->last_name;
                if(count($user->roles) > 0) {
                    foreach($user->roles as $role) {
                        $userRoles .= "<span class='badge bg-soft-primary me-1'>" . $role->name . "</span>";
                    }
                }
                $userArray[] = [
                    'id' => $user->id,
                    'name' => $userName, 
                    'roles' => $userRoles,
                    'email' => $user->email,
                //    'phone' => $user->phone,
                    'status' => $user->status,
                    'action' =>  $user->id
                ];
            }
        }

        return json_encode($userArray);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all roles
        $roles = Role::all();
        // get all permissions
        $permissionArray = $this->getAllPermissionsWithGroups();
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("User Create", "Users", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('users.create', compact('roles', 'permissionArray'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User;
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country = $request->country;

        // store image if exists
        if($request->hasFile('photo')) {
            $image = $request->file('photo');
            if($image instanceof UploadedFile) {
                // upload image and return image path
                $imageUrl = $this->uploadImage($image, 'avatar', 'avatars');

                $user->photo = $imageUrl;
            } 
        }

        $user->status = $request->active == 'on' ? 'active' : 'blocked';
        $user->save();

        // asign user a role
        $user->roles()->sync([$request->role_id]);
        // assign user permissions
        $user->permissions()->sync($request->permission_id);

        return redirect()->route('users.index')
                         ->with('success', 'New user created successfully');
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
        $user = User::with(['roles', 'permissions'])->find($id);
    	if(!isset($user) || empty($user)) {
    		abort(404);
    	}

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("User Edit", "Users", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::with('roles')->find($id);
    	if(!isset($user) || empty($user)) {
    		abort(404);
    	}

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country = $request->country;

        if($request->hasFile('photo')) {
            $image = $request->file('photo');
            if($image instanceof UploadedFile) {
                // delete previous image from folder/storage
                $this->deleteImage($user->photo);
                // upload image and return image path
                $imageUrl = $this->uploadImage($image, 'avatar', 'avatars');

                $user->photo = $imageUrl;
            } 
        }

        $user->status = $request->active == 'on' ? 'active' : 'blocked';
        $user->update();

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editUserRolePermissions($userId)
    {
        $userRoles = [];
        $userPermissions = [];
        $user = User::with('roles')->find($userId);
    	if(!isset($user) || empty($user)) {
    		abort(404);
    	}

        if(count($user->roles) > 0) {
            foreach($user->roles as $role) {
               $userRoles[] = (string) $role->id;
            }
        }

        $userRoles = json_encode($userRoles);

        if(count($user->permissions) > 0) {
            foreach($user->permissions as $permission) {
                $userPermissions[] = $permission->id;
            }
        }

        // get all roles
        $roles = Role::all();
        // get all permissions
        $permissionArray = $this->getAllPermissionsWithGroups();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Edit Roles & Permissions", "Users", "Edit Roles & Permissions");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('users.role_permission', compact('user', 'userRoles', 'userPermissions', 'roles', 'permissionArray'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUserRolePermissions(UserRolePermissionsUpdateRequest $request, $userId)
    {
        $user = User::with('roles')->find($userId);
    	if(!isset($user) || empty($user)) {
    		abort(404);
    	}

        // update user roles
        $user->roles()->sync($request->role_id);
        // update user permissions
        $user->permissions()->sync($request->permission_id);

        return redirect()->route('users.index')
                         ->with('success', 'User roles and permissions updated successfully');
    }
}

















