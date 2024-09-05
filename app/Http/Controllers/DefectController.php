<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
                $projName = isset($defect->projects) ? "#{$defect->projects->id} - {$defect->projects->name}" : "Project N/A";
                $defectName = "<div class='media'><div class='media-body align-self-center text-truncate'><h6 class='mt-0 mb-1 link-primary'>{$defect->name}</h6><p class='mb-0' data-bs-toggle='tooltip' data-bs-placement='top' title='Related To'>{$projName}</p></div></div>";
                $userName = $defect->assigned->first_name . ' ' . $defect->assigned->last_name;
                $user = "<a href=\"#\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"{$userName}\"><img src=\"{$defect->assigned->photo}\" class=\"rounded-circle thumb-sm\" /></a>";
                $defectArray[] = [
                    'id' => $defect->id,
                    'name' => $defectName, 
                    'start_date' => Carbon::parse($defect->start_date)->toFormattedDateString(),
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
        $defect->creator_id = auth()->user()->id;
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

        // get team
        $team = Team::find($request->team_id);
        // notify all team members about new defect
        if(isset($team)) {
            if(count($team->members) > 0) {
                foreach($team->members as $mem) {
                    $member = User::find($mem->id);
                    if(isset($member)) {
                        $member->notify(new NewDefectNotification($defect));
                    }
                }
            }
        }

        return redirect()->route('defects.index')
                         ->with('success', 'New defect created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $defect = Defect::with(['assigned', 'projects', 'teams'])->find($id);
        if(!isset($defect) || empty($defect)) {
    		abort(404);
    	}

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("{$defect->name}", "Defects", "Details");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('defects.show', compact('defect'));
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
        $defect = Defect::find($id);
    	if(!isset($defect) || empty($defect)) {
    		return response()->json([
                'success' => false,
                'message' => 'Woops! The requested resource was not found!'
            ], 404);
    	}

        $defect->delete();

        return response()->json([
            'success' => true,
            'message' => 'Well done! Defect deleted successfully.',
            'defect_id' => $id
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateDefectStatus(Request $request, $defectId)
    {
        $defect = Defect::find($defectId);
    	if(!isset($defect) || empty($defect)) {
    		return response()->json([
                'success' => false,
                'message' => 'Woops! The requested resource was not found!'
            ], 404);
    	}

        $defect->status = $request->status;

        $defect->update();
        
        return response()->json([
            'success' => true,
            'message' => 'Well done! Defect status updated successfully.'
        ], 200);   
    }
}
