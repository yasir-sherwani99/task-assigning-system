<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Team;
use App\Models\Defect;
use App\Models\Project;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\DefectStoreRequest;
use App\Notifications\NewDefectNotification;

class DefectController extends Controller
{
    use BreadcrumbTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = $this->getPagebreadcrumbs("Defects List", "Defects", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('defects.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function getDefects()
    {
        $defectArray = [];
        $defects = Defect::with(['assigned', 'projects'])->sort('desc')->get();
        
        if(count($defects) > 0) {
            foreach($defects as $defect) {
                $userName = $defect->assigned->first_name . ' ' . $defect->assigned->last_name;
                $user = "<a href=\"#\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"{$userName}\"><img src=\"{$defect->assigned->photo}\" class=\"rounded-circle thumb-sm\" /></a>";
                $defectArray[] = [
                    'id' => $defect->id,
                    'name' => $defect->name, 
                    'start_date' => Carbon::parse($defect->start_date)->toFormattedDateString(),
                    'end_date' => Carbon::parse($defect->end_date)->toFormattedDateString(),
                    'assigned' => $user,
                    'priority' => $defect->priority,
                    'status' => $defect->status,
                    'action' =>  $defect->id
                ];
            }
        }

        return json_encode($defectArray);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::sort('asc')->get();
        $projects = Project::sort('asc')->get();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Defect Create", "Defects", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('defects.create', compact('teams', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DefectStoreRequest $request)
    {
        $defect = new Defect;

        $defect->name = $request->name;
        $defect->project_id = $request->project_id;
        $defect->start_date = $request->start_date;
        $defect->end_date = $request->end_date;
        $defect->type = $request->defect_type;
        $defect->priority = $request->priority;
        $defect->team_id = $request->team_id;
        $defect->assigned_to_id = $request->assigned_to_id;
        $defect->estimated_hours = $request->estimated_hours;
        $defect->status = $request->status;
        $defect->description = $request->description;

        $defect->save();

        // get user whom task is assigned
        $member = User::find($request->assigned_to_id);
        // notify user
        if(isset($member)) {
            $member->notify(new NewDefectNotification($defect));
        }

        return redirect()->route('defects.index')
                         ->with('success', 'New defect created successfully');
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
        $defect = Defect::with(['assigned', 'projects', 'teams'])->find($id);
        if(!isset($defect) || empty($defect)) {
    		abort(404);
    	}

        $teams = Team::sort('asc')->get();
        $projects = Project::sort('asc')->get();

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Task Edit", "Tasks", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('defects.edit', compact('defect', 'teams', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DefectStoreRequest $request, string $id)
    {
        $defect = Defect::find($id);
        if(!isset($defect) || empty($defect)) {
    		abort(404);
    	}

        $defect->name = $request->name;
        $defect->project_id = $request->project_id;
        $defect->start_date = $request->start_date;
        $defect->end_date = $request->end_date;
        $defect->type = $request->defect_type;
        $defect->priority = $request->priority;
        $defect->team_id = $request->team_id;
        $defect->assigned_to_id = $request->assigned_to_id;
        $defect->estimated_hours = $request->estimated_hours;
        $defect->status = $request->status;
        $defect->description = $request->description;

        $defect->update();

        return redirect()->route('defects.index')
                         ->with('success', 'Defect updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
