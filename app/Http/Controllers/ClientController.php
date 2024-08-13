<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

use Image;

use App\Models\Client;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\ClientStoreRequest;

class ClientController extends Controller
{
    use BreadcrumbTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = $this->getPagebreadcrumbs("Client List", "Clients", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('clients.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function getClients()
    {
        $clientArray = [];
        $clients = Client::sort('desc')->get();
        
        if(count($clients) > 0) {
            foreach($clients as $user) {
                $userName = "<img src=\"{$user->company_logo}\" alt=\"{$user->first_name}\" class=\"rounded-circle thumb-sm me-2\" />" . $user->first_name . ' ' . $user->last_name;
                $clientArray[] = [
                    'id' => $user->id,
                    'name' => $userName, 
                    'company' => $user->company_name,
                    'designation' => $user->designation,
                    'status' => $user->status,
                    'action' =>  $user->id
                ];
            }
        }

        return json_encode($clientArray);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Client Create", "Clients", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientStoreRequest $request)
    {
        $client = new Client;
        
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->designation = $request->designation;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->city = $request->city;
        $client->country = $request->country;
        $client->company_name = $request->company_name;
        $client->company_email = $request->company_email;
        $client->company_address = $request->company_address;
        $client->company_city = $request->company_city;
        $client->company_country = $request->company_country;
        $client->company_website = $request->company_website;

        // store image if exists
        if($request->hasFile('company_logo')) {
            $image = $request->file('company_logo');
            if($image instanceof UploadedFile) {
                // image extension
                $extension = $image->getClientOriginalExtension();
                // destination path
                $destinationPath = public_path('images/upload/clients');
                // create image new name        
                $imageName = 'client_' . time() . '.' . $extension;
                // create image instanc and save
                $imageFile = Image::make($image->getRealPath());
                $imageFile->save($destinationPath . '/' . $imageName);
                // get image url
                $imageUrl = 'images/upload/clients/' . $imageName;

                $client->company_logo = $imageUrl;
            } 
        }

        $client->status = $request->active == 'on' ? 'active' : 'inactive';
        $client->save();

        return redirect()->route('clients.index')
                         ->with('success', 'New client created successfully');
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
        $client = Client::find($id);
    	if(!isset($client) || empty($client)) {
    		abort(404);
    	}

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Client Edit", "Clients", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::find($id);
    	if(!isset($client) || empty($client)) {
    		abort(404);
    	}

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->designation = $request->designation;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->city = $request->city;
        $client->country = $request->country;
        $client->company_name = $request->company_name;
        $client->company_email = $request->company_email;
        $client->company_address = $request->company_address;
        $client->company_city = $request->company_city;
        $client->company_country = $request->company_country;
        $client->company_website = $request->company_website;

        // store image if exists
        if($request->hasFile('company_logo')) {
            $image = $request->file('company_logo');
            if($image instanceof UploadedFile) {
                // delete previous image from folder
                if (File::exists(public_path($client->company_logo))) {
                    // delete image from storage
                    File::delete($client->company_logo);
                }
                // image extension
                $extension = $image->getClientOriginalExtension();
                // destination path
                $destinationPath = public_path('images/upload/clients');
                // create image new name        
                $imageName = 'client_' . time() . '.' . $extension;
                // create image instanc and save
                $imageFile = Image::make($image->getRealPath());
                $imageFile->save($destinationPath . '/' . $imageName);
                // get image url
                $imageUrl = 'images/upload/clients/' . $imageName;

                $client->company_logo = $imageUrl;
            } 
        }

        $client->status = $request->active == 'on' ? 'active' : 'inactive';
        $client->update();

        return redirect()->route('clients.index')
                         ->with('success', 'Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
