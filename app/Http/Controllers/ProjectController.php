<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use App\Models\Team;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\ProjectStoreRequest;
use App\Notifications\NewProjectNotification;
use App\Traits\ImageTrait;

class ProjectController extends Controller
{
    use BreadcrumbTrait, ImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['clients', 'teams'])->sort('desc')->paginate(9);

        $breadcrumbs = $this->getPagebreadcrumbs("Projects List", "Projects", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::sort('asc')->get();
        $clients = Client::sort('desc')->get();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Project Create", "Projects", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('projects.create', compact('teams', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request)
    {
        $project = new Project;

        $project->invoice_no = 'P-' . rand(10000, 99999);
        $project->name = $request->name;
        $project->version = $request->version;
        $project->creator_id = auth()->user()->id;
        $project->client_id = $request->client_id;
        $project->team_id = $request->team_id;
        $project->assigned_to_id = $request->assigned_to_id;
        $project->demo_url = $request->demo_url;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->description = $request->description;
        $project->billing_type = $request->billing_type;
        $project->estimated_hours = $request->estimated_hours;
        $project->budget = $request->budget;
        $project->is_auto_progress = isset($request->is_auto_progress) && $request->is_auto_progress == "on" ? 1 : 0;

        // store image if exists
        if($request->hasFile('logo')) {
            $image = $request->file('logo');
            if($image instanceof UploadedFile) {
                $imageUrl = $this->uploadImage($image, 'project', 'projects');

                $project->image = $imageUrl;
            } 
        }

        $project->status = $request->status;
        $project->save();

        $team = Team::find($request->team_id);
        if(!isset($team) || empty($team)) {
    		abort(404);
    	}

        // notify all team members about new project
        if(count($team->member) > 0) {
            foreach($team->member as $mem) {
                $member = User::find($mem->id);
                if(isset($member)) {
                    $member->notify(new NewProjectNotification($project));
                }
            }
        }

        return redirect()->route('projects.index')
                         ->with('success', 'New project created successfully');
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
        $project = Project::with(['clients', 'teams', 'assigned'])->find($id);
    	if(!isset($project) || empty($project)) {
    		abort(404);
    	}

        $teams = Team::sort('asc')->get();
        $clients = Client::sort('desc')->get();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Project Edit", "Projects", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('projects.edit', compact('project', 'teams', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectStoreRequest $request, string $id)
    {
        $project = Project::with(['clients', 'teams', 'assigned'])->find($id);
    	if(!isset($project) || empty($project)) {
    		abort(404);
    	}

        $project->name = $request->name;
        $project->version = $request->version;
        $project->client_id = $request->client_id;
        $project->team_id = $request->team_id;
        $project->assigned_to_id = $request->assigned_to_id;
        $project->demo_url = $request->demo_url;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->description = $request->description;
        $project->billing_type = $request->billing_type;
        $project->estimated_hours = $request->estimated_hours;
        $project->budget = $request->budget;
        $project->is_auto_progress = isset($request->is_auto_progress) && $request->is_auto_progress == "on" ? 1 : 0;

        // store image if exists
        if($request->hasFile('logo')) {
            $image = $request->file('logo');
            if($image instanceof UploadedFile) {
                // delete previous image from folder/storage
                $this->deleteImage($project->image);
                // upload image and return image path
                $imageUrl = $this->uploadImage($image, 'project', 'projects');

                $project->image = $imageUrl;
            } 
        }

        $project->status = $request->status;
        $project->update();

        return redirect()->route('projects.index')
                         ->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);
    	if(!isset($project) || empty($project)) {
    		abort(404);
    	}

         // delete previous image from folder/storage
        if(isset($project->image)) {
            $this->deleteImage($project->image); 
        }

        $project->delete();

        return redirect()->route('projects.index')
                         ->with('success', 'Project deleted successfully');
    }

    public function changeProjectStatus(Request $request, $projectId)
    {
        $project = Project::find($projectId);
    	if(!isset($project) || empty($project)) {
    		abort(404);
    	}

        $project->status = $request->status;

        $project->update();

        return redirect()->route('projects.index')
                         ->with('success', 'Project status updated successfully');
    }

    public function getProjectTeamMembers($projectId)
    {
        $data = [];
        $project = Project::with('teams')->find($projectId);
    	if(!isset($project) || empty($project)) {
    		abort(404);
    	}

        $data['members'] = $project->teams->member;

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}













