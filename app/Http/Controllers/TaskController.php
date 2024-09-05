<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Helpers\CustomHelper;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\TaskStoreRequest;
use App\Notifications\NewTaskNotification;
use App\Notifications\TaskStatusNotification;

class TaskController extends Controller
{
    use BreadcrumbTrait;

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

        $tasks = Task::with(['members', 'projects'])->sort('desc')->paginate(10);

        $breadcrumbs = $this->getPagebreadcrumbs("Tasks List", "Tasks", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('tasks.index', compact('tasks', 'view'));
    }

    /**
     * Display a listing of the resource.
     */
    public function getTasks()
    {
        $taskArray = [];
        $tasks = Task::with(['members', 'projects'])->sort('desc')->get();
        
        if(count($tasks) > 0) {
            foreach($tasks as $task) {
                $projName = isset($task->projects) ? "#{$task->projects->id} - {$task->projects->name}" : "Project N/A";
                $taskName = "<div class='media'><div class='media-body align-self-center text-truncate'><h6 class='mt-0 mb-1 link-primary'>{$task->name}</h6><p class='mb-0' data-bs-toggle='tooltip' data-bs-placement='top' title='Related To'>{$projName}</p></div></div>";
                $taskMembers = "";
                if(isset($task->members)) {
                    $taskMembers .= "<div class=\"img-group\">";
                    foreach($task->members as $key => $member) {
                        $username = $member->first_name . ' ' . $member->last_name;
                        if($key < 4) {
                            $image = asset($member->photo);
                            $taskMembers .= "<a href=\"#\" class=\"user-avatar\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"{$username}\">";
                            $taskMembers .= "<img src=\"{$image}\" alt=\"{$member->first_name}\" class=\"thumb-xs rounded-circle\" />";
                            $taskMembers .= "</a>";
                        }
                    }
                    if(count($task->members) > 4) {
                        $remaingtaskMembers = count($task->members) - 4;
                        $taskMembers .= "<a href=\"#\" class=\"user-avatar\">";
                        $taskMembers .= "<span class=\"thumb-xs justify-content-center d-flex align-items-center bg-soft-info rounded-circle fw-semibold\">+{$remaingtaskMembers}</span>";
                        $taskMembers .= "</a>";
                    }
                    $taskMembers .= "</div>";
                }

                $taskArray[] = [
                    'id' => $task->id,
                    'name' => $taskName, 
                    'start_date' => $task->start_date,
                    'assignees' => $taskMembers,
                    'priority' => $task->priority,
                    'status' => $task->status,
                    'action' =>  $task->id
                ];
            }
        }

        return json_encode($taskArray);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::sort('asc')->get();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Tasks Create", "Tasks", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $task = new Task;

        $task->name = $request->name;
        $task->creator_id = auth()->user()->id;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->estimated_hours = $request->estimated_hours;
        $task->priority = $request->priority;
        $task->status = $request->status;

        $task->save();

        // store task members
        $task->members()->sync($request->members);

        // get user whom task is assigned
        $members = User::whereIn('id', $request->members)->get();
        // notify user
        if(isset($members)) {
            if(count($members) > 0) {
                foreach($members as $mem) {
                    $mem->notify(new NewTaskNotification($task));
                }
            }
        }
        
        return redirect()->route('tasks.index')
                         ->with('success', 'New task created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with(['projects', 'members'])->find($id);
        if(!isset($task) || empty($task)) {
    		abort(404);
    	}

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("{$task->name}", "Tasks", "Details");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $defaultMembers = [];
        $selectedMembers = [];
        $task = Task::with(['projects', 'members'])->find($id);
        if(!isset($task) || empty($task)) {
    		abort(404);
    	}
    
        if(count($task->members) > 0) {
            foreach($task->members as $member) {
               $selectedMembers[] = (string) $member->id;
            }
        }

        $selectedMembers = json_encode($selectedMembers);

        if(isset($task->projects)) {
            if(isset($task->projects->teams)) {
                if(count($task->projects->teams->members) > 0) {
                    foreach($task->projects->teams->members as $mem) {
                        $defaultMembers[] = [
                            'value' => $mem->id,
                            'text' => $mem->first_name . ' ' . $mem->last_name,
                        ];
                    }
                }
            }
        }

        $defaultMembers = json_encode($defaultMembers);

        $projects = Project::sort('asc')->get();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Tasks Edit", "Tasks", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('tasks.edit', compact('selectedMembers', 'defaultMembers', 'task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskStoreRequest $request, string $id)
    {
        $task = Task::find($id);
        if(!isset($task) || empty($task)) {
    		abort(404);
    	}

        $task->name = $request->name;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->estimated_hours = $request->estimated_hours;
        $task->priority = $request->priority;
        $task->status = $request->status;

        $task->update();

        // update task members
        $task->members()->sync($request->members);

        return redirect()->route('tasks.index')
                         ->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
    	if(!isset($task) || empty($task)) {
    		abort(404);
    	}

        $task->members()->sync([]);
        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Task deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy2(string $id)
    {
        $task = Task::find($id);
    	if(!isset($task) || empty($task)) {
    		return response()->json([
                'success' => false,
                'message' => 'Woops! The requested resource was not found!'
            ], 404);
    	}

        $task->members()->sync([]);
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Well done! Task deleted successfully.',
            'task_id' => $id
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTaskStatus(Request $request, $taskId)
    {
        $task = Task::with(['projects', 'members'])->find($taskId);
    	if(!isset($task) || empty($task)) {
    		abort(404);
    	}

        $task->status = $request->status;
        if($request->status == "completed") {
            $task->progress = 100;
        }

        $task->update();

        // get project progress
        $projectProgress = $this->getProjectProgress($task->projects->id);
        // update project progress  
        $this->updateProjectProgress($task->projects->id, $projectProgress);
        // notify all task members 
        if(isset($task->members) && count($task->members) > 0) {
            foreach($task->members as $mem) {
                // notify members about change in task status
                $member = User::find($mem->id);
                if(isset($member)) {
                    $member->notify(new TaskStatusNotification($task));
                }
            }
        }
        
        if($request->request_type == "web") {
            return redirect()->route('tasks.index')
                         ->with('success', 'Task status updated successfully.');
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Well done! Task status updated successfully.'
            ], 200);   
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function myTasksIndex()
    {   
        $tasks = Task::where('assigned_to_id', auth()->user()->id)->sort('desc')->paginate(10);

        $breadcrumbs = $this->getPagebreadcrumbs("My Tasks", "Tasks", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTaskProgress(Request $request, $taskId)
    {
        $task = Task::find($taskId);
    	if(!isset($task) || empty($task)) {
    		abort(404);
    	}

        $task->progress = $request->progress;

        $task->update();

        return redirect()->route('tasks.index')
                         ->with('success', 'Task progress updated successfully');
    }

    public function getProjectProgress($projectId)
    {   
        $project = Project::with('task')->find($projectId);
        
        $completedTasks = 0;
        $totalTasks = count($project->task);
        if($totalTasks > 0) {
            foreach($project->task as $task) {
                if($task->status == "completed") {
                    $completedTasks += 1;
                }
            }

            $projectProgress = CustomHelper::calculatePercentage($completedTasks, $totalTasks);
        } else {
            $projectProgress = 0;
        }

        return $projectProgress;
    }

    public function updateProjectProgress($projectId, $progress)
    {
        $project = Project::find($projectId);
    	if(isset($project)) {
    		$project->progress = $progress;
    	}

        $project->update();
    }
}












