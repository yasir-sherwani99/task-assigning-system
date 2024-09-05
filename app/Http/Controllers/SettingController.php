<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\PasswordChangeRequest;

class SettingController extends Controller
{
    use BreadcrumbTrait;

    /**
     * Show the form for creating a new resource.
     */
    public function createPassword()
    {
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Password", "Settings", "Change Password");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('password.create');   
    }

    /**
     * Update the specified resource in storage.
     */
    public function changePassword(PasswordChangeRequest $request)
    {
        $user = User::find(auth()->user()->id);
        if(!isset($user) || empty($user)) {
    		abort(404);
    	}

        if(Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();

            Session::flash('success', "Your account password has been changed successfully.");
            return redirect()->back();
        } else {
            Session::flash('alert', 'Incorrect current/existing password, Please try again.');
            return redirect()->back();
        }
    }
}
