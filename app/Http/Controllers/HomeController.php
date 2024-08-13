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

class HomeController extends Controller
{
    use BreadcrumbTrait;

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
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Dashboard", null, "Dashboard");
        view()->share('breadcrumbs', $breadcrumbs);

        $totalTasks = Task::count();
        $stats['total_projects'] = Project::count();
        $stats['total_clients'] = Client::count();
        $stats['total_teams'] = Team::count();
        $stats['total_tasks'] = $totalTasks;
        $stats['total_users'] = User::count();

        $taskOpenTotal = Task::open()->count();
        $taskInProgressTotal = Task::inProgress()->count();
        $taskCompletedTotal = Task::completed()->count();
        
        // $taskPercentage['open'] = $totalTasks > 0 ? CustomHelper::calculatePercentage($taskOpenTotal, $totalTasks) : 0;
        // $taskPercentage['in_progress'] = $totalTasks > 0 ? CustomHelper::calculatePercentage($taskInProgressTotal, $totalTasks) : 0;
        // $taskPercentage['completed'] = $totalTasks > 0 ? CustomHelper::calculatePercentage($taskCompletedTotal, $totalTasks) : 0;
        
        $taskPercentage['open'] = 71;
        $taskPercentage['in_progress'] = 63;
        $taskPercentage['completed'] = 76;
        // dd($taskPercentage);

        return view('dashboard.index', compact('stats', 'taskPercentage'));
    }
}
