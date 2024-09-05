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
        $stats = [];
        $taskPercentage = [];
        $startDate = now()->subMonths(12)->format('jS M Y');
        $endDate = now()->format('jS M Y');
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Dashboard", null, "Dashboard");
        view()->share('breadcrumbs', $breadcrumbs);

        $totalProjects = Project::count();
        $projectOpenTotal = Project::open()->count();
        $projectInProgressTotal = Project::inProgress()->count();
        $projectCompletedTotal = Project::completed()->count();
        $projectOverDueTotal = Project::whereDate('end_date', '<', now()->format('Y-m-d'))->where('status', '<>', 'completed')->count();

        $totalTasks = Task::count();
        $taskOpenTotal = Task::open()->count();
        $taskInProgressTotal = Task::inProgress()->count();
        $taskCompletedTotal = Task::completed()->count();
        $taskOverDueTotal = Task::whereDate('end_date', '<', now()->format('Y-m-d'))->where('status', '<>', 'completed')->count();

        $totalDefects = Defect::count();
        $defectOpenTotal = Defect::open()->count();
        $defectInProgressTotal = Defect::inProgress()->count();
        $defectSolvedTotal = Defect::solved()->count();
        $defectOverDueTotal = Defect::whereDate('end_date', '<', now()->format('Y-m-d'))->where('status', '<>', 'solved')->count();

        $stats['total_projects'] = $totalProjects;
        $stats['projects_in_progress'] = $projectInProgressTotal;
        $stats['projects_over_due'] = $projectOverDueTotal;
        $stats['total_clients'] = Client::count();
        $stats['active_clients'] = Client::active()->count();
        $stats['total_teams'] = Team::count();
        $stats['total_tasks'] = $totalTasks;
        $stats['tasks_in_progress'] = $taskInProgressTotal;
        $stats['tasks_over_due'] = $taskOverDueTotal;
        $stats['total_defects'] = $totalDefects;
        $stats['defects_in_progress'] = $defectInProgressTotal;
        $stats['defects_over_due'] = $defectOverDueTotal;
        $stats['total_users'] = User::count();

        //$startDate = now()->subMonths(12)
        $totalTasks2 = Task::where('created_at', '>=', now()->subMonths(12))->count();
        $taskOpenTotal2 = Task::open()->where('created_at', '>=', now()->subMonths(12))->count();
        $taskInProgressTotal2 = Task::inProgress()->where('created_at', '>=', now()->subMonths(12))->count();
        $taskCompletedTotal2 = Task::completed()->where('created_at', '>=', now()->subMonths(12))->count();

        $taskPercentage['open'] = $totalTasks2 > 0 ? CustomHelper::calculatePercentage($taskOpenTotal2, $totalTasks2) : 0;
        $taskPercentage['in_progress'] = $totalTasks2 > 0 ? CustomHelper::calculatePercentage($taskInProgressTotal2, $totalTasks2) : 0;
        $taskPercentage['completed'] = $totalTasks2 > 0 ? CustomHelper::calculatePercentage($taskCompletedTotal2, $totalTasks2) : 0;

        $totalProjects2 = Project::where('created_at', '>=', now()->subMonths(12))->count();
        $projectOpenTotal2 = Project::open()->where('created_at', '>=', now()->subMonths(12))->count();
        $projectInProgressTotal2 = Project::inProgress()->where('created_at', '>=', now()->subMonths(12))->count();
        $projectCompletedTotal2 = Project::completed()->where('created_at', '>=', now()->subMonths(12))->count();

        $projectPercentage['open'] = $totalProjects2 > 0 ? CustomHelper::calculatePercentage($projectOpenTotal2, $totalProjects2) : 0;
        $projectPercentage['in_progress'] = $totalProjects2 > 0 ? CustomHelper::calculatePercentage($projectInProgressTotal2, $totalProjects2) : 0;
        $projectPercentage['completed'] = $totalProjects2 > 0 ? CustomHelper::calculatePercentage($projectCompletedTotal2, $totalProjects2) : 0;

        $totalDefects2 = Defect::where('created_at', '>=', now()->subMonths(12))->count();
        $defectOpenTotal2 = Defect::open()->where('created_at', '>=', now()->subMonths(12))->count();
        $defectInProgressTotal2 = Defect::inProgress()->where('created_at', '>=', now()->subMonths(12))->count();
        $defectSolvedTotal2 = Defect::solved()->where('created_at', '>=', now()->subMonths(12))->count();

        $defectPercentage['open'] = $totalDefects2 > 0 ? CustomHelper::calculatePercentage($defectOpenTotal2, $totalDefects2) : 0;
        $defectPercentage['in_progress'] = $totalDefects2 > 0 ? CustomHelper::calculatePercentage($defectInProgressTotal2, $totalDefects2) : 0;
        $defectPercentage['solved'] = $totalDefects2 > 0 ? CustomHelper::calculatePercentage($defectSolvedTotal2, $totalDefects2) : 0;

        // get graph data of tasks and defects
        $graphData = $this->getOverviewGraphData();
        // get latest projects
        $latestProjects = Project::latest()->take(10)->get();

        return view('dashboard.index', compact('stats', 'taskPercentage', 'startDate', 'endDate', 'projectPercentage', 'defectPercentage', 'graphData', 'latestProjects'));
    }

    public function getOverviewGraphData()
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
