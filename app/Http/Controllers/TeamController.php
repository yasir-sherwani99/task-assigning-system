<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    public function index(Request $request)
    {
        if($request->input('view') !== null) {
            $view = $request->input('view');
        } else {
            $view = null;
        }

        $teams = Team::with(['members','leader'])->sort('desc')->paginate(9);
        
        $breadcrumbs = $this->getPagebreadcrumbs("Team List", "Teams", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('teams.index', compact('view', 'teams'));
    }

     /**
     * Display a listing of the resource.
     */
    public function getTeams()
    {
        $teamArray = [];
        $teams = Team::with(['members', 'leader'])->sort('desc')->get();
        
        if(count($teams) > 0) {
            foreach($teams as $team) {
                $teamMembers = "";
                if(isset($team->members)) {
                    $teamMembers .= "<div class=\"img-group\">";
                    foreach($team->members as $key => $member) {
                        $username = $member->first_name . ' ' . $member->last_name;
                        if($key < 4) {
                            $image = asset($member->photo);
                            $teamMembers .= "<a href=\"#\" class=\"user-avatar\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"{$username}\">";
                            $teamMembers .= "<img src=\"{$image}\" alt=\"{$member->first_name}\" class=\"thumb-xs rounded-circle\" />";
                            $teamMembers .= "</a>";
                        }
                    }
                    if(count($team->members) > 4) {
                        $remaingTeamMembers = count($team->members) - 4;
                        $teamMembers .= "<a href=\"#\" class=\"user-avatar\">";
                        $teamMembers .= "<span class=\"thumb-xs justify-content-center d-flex align-items-center bg-soft-info rounded-circle fw-semibold\">+{$remaingTeamMembers}</span>";
                        $teamMembers .= "</a>";
                    }
                    $teamMembers .= "</div>";
                }

                $teamArray[] = [
                    'id' => $team->id,
                    'name' => $team->name, 
                    'leader' => $team->leader->first_name . ' ' . $team->leader->last_name,
                    'members' => $teamMembers,
                    'action' =>  $team->id
                ];
            }
        }

        return json_encode($teamArray);
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
        $team->members()->sync($request->members);

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
        $team = Team::with(['members','leader'])->find($id);
        if(!isset($team) || empty($team)) {
    		abort(404);
    	}

        if(count($team->members) > 0) {
            foreach($team->members as $member) {
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
        $team = Team::with('members')->find($id);
        if(!isset($team) || empty($team)) {
    		abort(404);
    	}

        $team->name = $request->name;
        $team->leader_id = $request->leader_id;
        $team->description = $request->description;

        $team->update();
        // update team members
        $team->members()->sync($request->members);

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

        $team->members()->sync([]);

        $team->delete();               

        return redirect()->route('teams.index')
                         ->with('success', 'Team deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy2(string $id)
    {
        $team = Team::find($id);
        if(!isset($team) || empty($team)) {
    		return response()->json([
                'success' => false,
                'message' => 'Woops! The requested resource was not found!'
            ], 404);
    	}

        $team->members()->sync([]);

        $team->delete();               

        return response()->json([
            'success' => true,
            'message' => 'Well done! Team deleted successfully.',
            'team_id' => $id
        ], 200);
    }

    public function getTeamMembers($teamId)
    {
        $data = [];
        $team = Team::with('members')->find($teamId);
        if(!isset($team) || empty($team)) {
    		abort(404);
    	}

        $data['members'] = $team->members;

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}











