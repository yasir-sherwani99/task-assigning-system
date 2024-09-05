<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

use App\Models\Team;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\ProjectStoreRequest;
use App\Notifications\NewProjectNotification;
use App\Notifications\ProjectStatusNotification;
use App\Traits\ImageTrait;

class ProjectController extends Controller
{
    use BreadcrumbTrait, ImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->input('view') !== null) {
            $view = $request->input('view');
        } else {
            $view = null;
        }

        $projects = Project::with(['clients', 'teams'])->sort('desc')->paginate(9);

        $breadcrumbs = $this->getPagebreadcrumbs("Projects List", "Projects", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('projects.index', compact('view', 'projects'));
    }

    /**
     * Display a listing of the resource.
     */
    public function getProjects()
    {
        $projectArray = [];
        $projects = Project::with(['clients', 'teams'])->sort('desc')->get();
        
        if(count($projects) > 0) {
            foreach($projects as $project) {
                $projName = "<div class='media'><div class='media-body align-self-center text-truncate'><h6 class='mt-0 mb-1 link-primary'>{$project->name}</h6><p class='mb-0'><b>Client</b>: {$project->clients->company_name}</p></div></div>";
            //    $userName = $project->assigned->first_name . ' ' . $project->assigned->last_name;
            //    $user = "<a href=\"#\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"{$userName}\"><img src=\"{$project->assigned->photo}\" class=\"rounded-circle thumb-sm\" /></a>";
                $projectArray[] = [
                    'id' => $project->id,
                    'name' => $projName, 
                    'start_date' => Carbon::parse($project->start_date)->toFormattedDateString(),
                //    'end_date' => Carbon::parse($project->end_date)->toFormattedDateString(),
                    'assigned' => isset($project->teams) ? $project->teams->name : 'N/A',
                    'progress' => $project->progress,
                    'status' => $project->status,
                    'action' =>  $project->id
                ];
            }
        }

        return json_encode($projectArray);
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

        // get team
        $team = Team::find($request->team_id);
        // notify all team members about new project
        if(isset($team)) {
            if(count($team->members) > 0) {
                foreach($team->members as $mem) {
                    $member = User::find($mem->id);
                    if(isset($member)) {
                        $member->notify(new NewProjectNotification($project));
                    }
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
        $data = [];
        $project = Project::with(['clients', 'teams', 'assigned'])->find($id);
        if(!isset($project) || empty($project)) {
    		abort(404);
    	}

        $openTasks = 0;
        $totalProjectTasks = count($project->task);
        if($totalProjectTasks > 0) {
            foreach($project->task as $task) {
                if($task->status == "open") {
                    $openTasks += 1;  
                }
            }

            $openTaskPercentage = CustomHelper::calculatePercentage($openTasks, $totalProjectTasks);
        } else {
            $openTaskPercentage = 0;
        }

        $data['open_tasks'] = $openTasks;
        $data['total_tasks'] = $totalProjectTasks;
        $data['open_task_percentage'] = $openTaskPercentage;
 
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("{$project->name}", "Projects", "Details");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('projects.show', compact('project', 'data'));
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy2(string $id)
    {
        $project = Project::find($id);
    	if(!isset($project) || empty($project)) {
    		return response()->json([
                'success' => false,
                'message' => 'Woops! The requested resource was not found!'
            ], 404);
    	}

         // delete previous image from folder/storage
        if(isset($project->image)) {
            $this->deleteImage($project->image); 
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Well done! Project deleted successfully.',
            'project_id' => $id
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function changeProjectStatus(Request $request, $projectId)
    {
        $project = Project::with('teams')->find($projectId);
    	if(!isset($project) || empty($project)) {
    		abort(404);
    	}

        $project->status = $request->status;

        $project->update();

        // get team
        $team = Team::find($project->team_id);
        // notify all team members about change in project status
        if(isset($team)) {
            if(count($team->members) > 0) {
                foreach($team->members as $mem) {
                    $member = User::find($mem->id);
                    if(isset($member)) {
                        $member->notify(new ProjectStatusNotification($project));
                    }
                }
            }
        }

        if($request->request_type == "web") {
            return redirect()->route('projects.index')
                            ->with('success', 'Project status updated successfully.');
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Well done! Project status updated successfully.'
            ], 200);   
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function getProjectTeamMembers($projectId)
    {
        $data = [];
        $project = Project::with('teams')->find($projectId);
    	if(!isset($project) || empty($project)) {
    		return response()->json([
                'success' => false,
                'message' => 'Woops! The requested resource was not found!'
            ], 404);
    	}

        $data['members'] = isset($project->teams) ? $project->teams->members : null;

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProjectProgress(Request $request, $projectId)
    {
        $project = Project::find($projectId);
    	if(!isset($project) || empty($project)) {
    		abort(404);
    	}

        $project->progress = $request->progress;

        $project->update();

        return redirect()->route('projects.index')
                         ->with('success', 'Project progress updated successfully');   
    }
}













