<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Project;
use App\Models\Task;
use App\Models\Defect;
use App\Traits\BreadcrumbTrait;

class ReportController extends Controller
{
    use BreadcrumbTrait;

    /**
     * Display a listing of the resource.
     */
    public function projectReportIndex()
    {
        $breadcrumbs = $this->getPagebreadcrumbs("Project Report", "Reports", "Project");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('reports.project');
    }

    public function getProjectReport()
    {
        $projectArray = [];
        $projects = Project::with(['clients', 'teams'])->sort('desc')->get();
        
        if(count($projects) > 0) {
            foreach($projects as $project) {
                $startTime = Carbon::parse($project->start_date);  
                $hours = number_format((float)$startTime->floatDiffInRealHours($project->end_date), 2, ':', '');

                $projectArray[] = [
                //    'id' => $project->id,
                    'invoice' => $project->invoice_no,
                    'name' => $project->name, 
                    'client' => isset($project->clients) ? $project->clients->first_name . ' ' . $project->clients->last_name : 'N/A',
                    'start' => $project->start_date,
                    'end' => $project->end_date,
                    'hours' => $hours,
                    'status' => $project->status,
                    'billing' => $project->billing_type,
                    'budget' => $project->budget
                ];
            }
        }

        return json_encode($projectArray);
    }

    /**
     * Display a listing of the resource.
     */
    public function taskReportIndex()
    {
        $breadcrumbs = $this->getPagebreadcrumbs("Task Report", "Reports", "Task");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('reports.task');
    }

    public function getTaskReport()
    {
        $taskArray = [];
        $tasks = Task::with(['projects', 'assigned'])->sort('desc')->get();
        
        if(count($tasks) > 0) {
            foreach($tasks as $task) {
                $startTime = Carbon::parse($task->start_date);  
                $hours = number_format((float)$startTime->floatDiffInRealHours($task->end_date), 2, ':', '');

                $taskArray[] = [
                //    'id' => $task->id,
                    'name' => $task->name, 
                    'project' => isset($task->projects) ? $task->projects->name : 'N/A',
                    'assigned' => isset($task->assigned) ? $task->assigned->first_name . ' ' . $task->assigned->last_name : 'N/A',
                    'start' => $task->start_date,
                    'end' => $task->end_date,
                    'hours' => $hours,
                    'progress' => $task->progress,
                    'priority' => $task->priority
                ];
            }
        }

        return json_encode($taskArray);
    }

    public function defectReportIndex()
    {
        $breadcrumbs = $this->getPagebreadcrumbs("Defect Report", "Reports", "Defect");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('reports.defect');        
    }

    public function getDefectReport()
    {
        $defectArray = [];
        $defects = Defect::with(['projects', 'assigned', 'teams'])->sort('desc')->get();
        
        if(count($defects) > 0) {
            foreach($defects as $defect) {
                $startTime = Carbon::parse($defect->start_date);  
                $hours = number_format((float)$startTime->floatDiffInRealHours($defect->end_date), 2, ':', '');

                $defectArray[] = [
                    'id' => $defect->id,
                    'name' => $defect->name, 
                    'project' => isset($defect->projects) ? $defect->projects->name : 'N/A',
                    'assigned' => isset($defect->assigned) ? $defect->assigned->first_name . ' ' . $defect->assigned->last_name : 'N/A',
                    'start' => $defect->start_date,
                    'end' => $defect->end_date,
                    'hours' => $hours,
                    'type' => $defect->type,
                    'priority' => $defect->priority,
                    'status' => $defect->status
                ];
            }
        }

        return json_encode($defectArray);
    }
}











