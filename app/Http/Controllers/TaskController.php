<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\TaskStoreRequest;
use App\Notifications\NewTaskNotification;
use App\Notifications\TaskStatusChangeNotification;

class TaskController extends Controller
{
    use BreadcrumbTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::sort('desc')->paginate(10);

        $breadcrumbs = $this->getPagebreadcrumbs("Tasks List", "Tasks", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('tasks.index', compact('tasks'));
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
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->assigned_to_id = $request->assigned_to_id;
        $task->estimated_hours = $request->estimated_hours;
        $task->priority = $request->priority;
        $task->status = $request->status;

        $task->save();

        // get user whom task is assigned
        $member = User::find($request->assigned_to_id);
        // notify user
        if(isset($member)) {
            $member->notify(new NewTaskNotification($task));
        }

        return redirect()->route('tasks.index')
                         ->with('success', 'New task created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with(['projects', 'assigned'])->find($id);
        if(!isset($task) || empty($task)) {
    		abort(404);
    	}

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Task View", "Tasks", "View");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::with(['projects', 'assigned'])->find($id);
        if(!isset($task) || empty($task)) {
    		abort(404);
    	}

        $projects = Project::sort('asc')->get();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Tasks Edit", "Tasks", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('tasks.edit', compact('task', 'projects'));
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
        $task->assigned_to_id = $request->assigned_to_id;
        $task->estimated_hours = $request->estimated_hours;
        $task->priority = $request->priority;
        $task->status = $request->status;

        $task->update();

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

        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Task deleted successfully');
    }

    public function changeTaskStatus(Request $request, $taskId)
    {
        $task = Task::find($taskId);
    	if(!isset($task) || empty($task)) {
    		abort(404);
    	}

        $task->status = $request->status;

        $task->update();

        // get user whom task is assigned
        $member = User::find($task->assigned_to_id);
        // notify user
        if(isset($member)) {
            $member->notify(new TaskStatusChangeNotification($task));
        }

        return redirect()->route('tasks.index')
                         ->with('success', 'Task status updated successfully');
    }

    public function myTasksIndex()
    {   
        $tasks = Task::where('assigned_to_id', auth()->user()->id)->sort('desc')->paginate(10);

        $breadcrumbs = $this->getPagebreadcrumbs("My Tasks", "Tasks", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('tasks.index', compact('tasks'));
    }
}
