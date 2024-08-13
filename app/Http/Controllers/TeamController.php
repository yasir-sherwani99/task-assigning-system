<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\User;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\TeamStoreRequest;
use App\Models\TeamMember;

class TeamController extends Controller
{
    use BreadcrumbTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::with(['member','leader'])->sort('desc')->get();

        $breadcrumbs = $this->getPagebreadcrumbs("Team List", "Teams", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::active()->get();

        $breadcrumbs = $this->getPagebreadcrumbs("Team Create", "Teams", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('teams.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamStoreRequest $request)
    {
        $team = new Team;

        $team->name = $request->name;
        $team->leader_id = $request->leader_id;
        $team->description = $request->description;

        $team->save();
        // store team members
        $team->member()->sync($request->members);

        return redirect()->route('teams.index')
                         ->with('success', 'New team created successfully');
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
        $selectedMembers = [];
        $team = Team::with(['member','leader'])->find($id);
        if(!isset($team) || empty($team)) {
    		abort(404);
    	}

        if(count($team->member) > 0) {
            foreach($team->member as $member) {
               $selectedMembers[] = (string) $member->id;
            }
        }

        $selectedMembers = json_encode($selectedMembers);

        $users = User::active()->get();

        $breadcrumbs = $this->getPagebreadcrumbs("Team Edit", "Teams", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('teams.edit', compact('team', 'selectedMembers', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $team = Team::with('member')->find($id);
        if(!isset($team) || empty($team)) {
    		abort(404);
    	}

        $team->name = $request->name;
        $team->leader_id = $request->leader_id;
        $team->description = $request->description;

        $team->update();
        // update team members
        $team->member()->sync($request->members);

        return redirect()->route('teams.index')
                         ->with('success', 'Team updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = Team::find($id);
        if(!isset($team) || empty($team)) {
    		abort(404);
    	}

        $team->member()->sync([]);

        $team->delete();               

        return redirect()->route('teams.index')
                         ->with('success', 'Team deleted successfully');
    }

    public function getTeamMembers($teamId)
    {
        $data = [];
        $team = Team::with('member')->find($teamId);
        if(!isset($team) || empty($team)) {
    		abort(404);
    	}

        $data['members'] = $team->member;

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}











