<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Models\Client;
use App\Traits\BreadcrumbTrait;
use App\Helpers\CustomHelper;
use App\Models\Defect;
use App\Traits\PermissionTrait;

class HomeController extends Controller
{
    use BreadcrumbTrait, PermissionTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      //  dd(auth()->user()->hasRole('admin'));
        $stats = [];
        $taskPercentage = [];
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Dashboard", null, "Dashboard");
        view()->share('breadcrumbs', $breadcrumbs);

        $totalProjects = Project::count();
        $projectOpenTotal = Project::open()->count();
        $projectInProgressTotal = Project::inProgress()->count();
        $projectCompletedTotal = Project::completed()->count();

        $totalTasks = Task::count();
        $taskOpenTotal = Task::open()->count();
        $taskInProgressTotal = Task::inProgress()->count();
        $taskCompletedTotal = Task::completed()->count();

        $totalDefects = Defect::count();
        $defectOpenTotal = Defect::open()->count();
        $defectInProgressTotal = Defect::inProgress()->count();
        $defectSolvedTotal = Defect::solved()->count();

        $stats['total_projects'] = $totalProjects;
        $stats['projects_in_progress'] = $projectInProgressTotal;
        $stats['total_clients'] = Client::count();
        $stats['total_teams'] = Team::count();
        $stats['total_tasks'] = $totalTasks;
        $stats['tasks_in_progress'] = $taskInProgressTotal;
        $stats['total_defects'] = $totalDefects;
        $stats['defects_in_progress'] = $defectInProgressTotal;
        $stats['total_users'] = User::count();
        
        // $taskPercentage['open'] = $totalTasks > 0 ? CustomHelper::calculatePercentage($taskOpenTotal, $totalTasks) : 0;
        // $taskPercentage['in_progress'] = $totalTasks > 0 ? CustomHelper::calculatePercentage($taskInProgressTotal, $totalTasks) : 0;
        // $taskPercentage['completed'] = $totalTasks > 0 ? CustomHelper::calculatePercentage($taskCompletedTotal, $totalTasks) : 0;
        
        $taskPercentage['open'] = 71;
        $taskPercentage['in_progress'] = 63;
        $taskPercentage['completed'] = 76;

        $projectPercentage['open'] = $totalProjects > 0 ? CustomHelper::calculatePercentage($projectOpenTotal, $totalProjects) : 0;
        $projectPercentage['in_progress'] = $totalProjects > 0 ? CustomHelper::calculatePercentage($projectInProgressTotal, $totalProjects) : 0;
        $projectPercentage['completed'] = $totalProjects > 0 ? CustomHelper::calculatePercentage($projectCompletedTotal, $totalProjects) : 0;

        $defectPercentage['open'] = $totalDefects > 0 ? CustomHelper::calculatePercentage($defectOpenTotal, $totalDefects) : 0;
        $defectPercentage['in_progress'] = $totalDefects > 0 ? CustomHelper::calculatePercentage($defectInProgressTotal, $totalDefects) : 0;
        $defectPercentage['solved'] = $totalDefects > 0 ? CustomHelper::calculatePercentage($defectSolvedTotal, $totalDefects) : 0;

        $graphData = $this->getGraphData();
      //  dd($graphData);

        return view('dashboard.index', compact('stats', 'taskPercentage', 'projectPercentage', 'defectPercentage', 'graphData'));
    }

    public function getGraphData()
    {
        $data = [];
        // last one year 
        $duration = now()->subMonths(11)->monthsUntil(now());
        $durationData = [];
        $lastOneYearDates = [];

        foreach ($duration as $dur) {
            $durationData[] = [
                'month' => $dur->month,
                'year' => $dur->year,
            ];
            $date = $dur->format('M Y');
            array_push($lastOneYearDates, $date);
        }
        
        $data['dates'] = json_encode($lastOneYearDates);
        $data['start_date'] = $lastOneYearDates[0];
        $data['end_date'] = $lastOneYearDates[count($lastOneYearDates) - 1];
        $data['tasks'] = json_encode($this->countTasksByDuration($durationData));
        $data['defects'] = json_encode($this->countDefectsByDuration($durationData));

        return $data;
    }

    public function countTasksByDuration($durationData)
    {
        $tasks = [];
        foreach($durationData as $data) {
            // count month wise tasks
            $total = (integer) Task::whereMonth('created_at', $data['month'])->whereYear('created_at', $data['year'])->count();
            array_push($tasks, $total);
        }

		return $tasks;
    }

    public function countDefectsByDuration($durationData)
    {
        $defects = [];
        foreach($durationData as $data) {
            // count month wise defects
            $total = (integer) Defect::whereMonth('created_at', $data['month'])->whereYear('created_at', $data['year'])->count();
            array_push($defects, $total);
        }

		return $defects;
    }
}
