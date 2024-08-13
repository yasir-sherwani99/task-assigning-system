<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

use Image;

use App\Models\User;
use App\Models\Role;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Traits\PermissionTrait;

class UserController extends Controller
{
    use BreadcrumbTrait, PermissionTrait;

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
        $users = User::sort('desc')->get();
        
        if(count($users) > 0) {
            foreach($users as $user) {
                $userName = "<img src=\"{$user->photo}\" alt=\"{$user->first_name}\" class=\"rounded-circle thumb-sm me-2\" />" . $user->first_name . ' ' . $user->last_name;
                $userRoles = "";
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
        $roles = Role::all();
        // get all permissions
        $permissionArray = $this->getPermissions();
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
                // image extension
                $extension = $image->getClientOriginalExtension();
                // destination path
                $destinationPath = public_path('images/upload/avatars');
                // create image new name        
                $imageName = 'avatar_' . time() . '.' . $extension;
                // create image instanc and save
                $imageFile = Image::make($image->getRealPath());
                $imageFile->save($destinationPath . '/' . $imageName);
                // get image url
                $imageUrl = 'images/upload/avatars/' . $imageName;

                $user->photo = $imageUrl;
            } 
        }

        $user->status = $request->active == 'on' ? 'active' : 'blocked';
        $user->save();

        // get role
        $role = Role::find($request->role_id);
        if(!isset($role) || empty($role)) {
    		abort(404);
    	}

        // assign user role
        $user->roles()->attach($role->id);
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
        $user = User::with('roles')->find($id);
    	if(!isset($user) || empty($user)) {
    		abort(404);
    	}

        $roles = Role::all();
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("User Edit", "Users", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('users.edit', compact('user', 'roles'));
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
        $user->role_id = $request->role_id;

        if($request->hasFile('photo')) {
            $image = $request->file('photo');
            if($image instanceof UploadedFile) {
                // delete previous image from folder
                if (File::exists(public_path($user->photo))) {
                    // delete image from storage
                    File::delete($user->photo);
                }
                // image extension
                $extension = $image->getClientOriginalExtension();
                // destination path
                $destinationPath = public_path('images/upload/avatars');
                // create image new name        
                $imageName = 'avatar_' . time() . '.' . $extension;
                // create image instanc and save
                $imageFile = Image::make($image->getRealPath());
                $imageFile->save($destinationPath . '/' . $imageName);
                // get image url
                $imageUrl = 'images/upload/avatars/' . $imageName;

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
}
