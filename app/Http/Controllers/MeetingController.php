<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
// use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Client;
use App\Models\Meeting;
use App\Models\Project;
use App\Notifications\MeetingStatusNotification;
use App\Notifications\NewMeetingNotification;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\MeetingStoreRequest;
// use Carbon\Carbon;

class MeetingController extends Controller
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

        $stats = [];
        $meetingData = [];
        $meetingWrapper = [];
        $meetings = Meeting::sort('desc')->paginate(10);

        $stats['total_meetings'] = Meeting::count();
        $stats['open_meetings'] = Meeting::open()->count();
        $stats['completed_meetings'] = Meeting::completed()->count();
        $stats['in_progress_meetings'] = Meeting::inProgress()->count();

        if(count($meetings) > 0) {
            foreach($meetings as $meeting) {
                
                if($meeting->status == "open") {
                    $className = "bg-soft-info";
                } elseif($meeting->status == "in_progress") {
                    $className = "bg-soft-warning";
                } elseif($meeting->status == "cancel") {
                    $className = "bg-soft-danger";
                } else {
                    $className = "bg-soft-success";
                }

                $meetingData['title'] = $meeting->title;
                $meetingData['start'] = $meeting->start_date;
                $meetingData['end'] = $meeting->end_date;
             //   $meetingData['date'] = Carbon::parse($meeting->start_date)->toDayDateTimeString();
                $meetingData['className'] = $className;
                $meetingData['textColor'] = '#303e67';
             //   $meetingData['status'] = $meeting->status;

                $meetingWrapper[] = $meetingData;
            }
        }

        $meetingCalendarData = json_encode($meetingWrapper);

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Meetings List", "Meetings", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('meetings.index', compact('meetings', 'stats', 'view', 'meetingCalendarData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $clients = Client::all();
        $projects = Project::all();
        
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Meetings Create", "Meetings", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('meetings.create', compact('users', 'clients', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeetingStoreRequest $request)
    {
        $meeting = new Meeting();

        $meeting->title = $request->title;
        $meeting->organizer_id = auth()->user()->id;
        $meeting->start_date = $request->start_date;
        $meeting->end_date = $request->end_date;
        $meeting->project_id = $request->project_id;
        $meeting->client_id = $request->client_id;
        $meeting->location = $request->location;
        $meeting->description = $request->description;

        $meeting->save();

        $meeting->members()->sync($request->members);

        // get users whom meeting is assigned
        $members = User::whereIn('id', $request->members)->get();
        // notify users
        if(isset($members)) {
            Notification::send($members, new NewMeetingNotification($meeting));
        }

        return redirect()->route('meetings.index')
                         ->with('success', 'New meeting created successfully');
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
        $meetingMembers = [];
        $meeting = Meeting::with(['projects','clients','members'])->find($id);
    	if(!isset($meeting) || empty($meeting)) {
    		abort(404);
    	}

        if(count($meeting->members) > 0) {
            foreach($meeting->members as $member) {
               $meetingMembers[] = (string) $member->id;
            }
        }

        $meetingMembers = json_encode($meetingMembers);

        $users = User::all();
        $clients = Client::all();
        $projects = Project::all();
        
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Meetings Edit", "Meetings", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('meetings.edit', compact('meeting', 'meetingMembers', 'users', 'clients', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MeetingStoreRequest $request, string $id)
    {
        $meeting = Meeting::find($id);
    	if(!isset($meeting) || empty($meeting)) {
    		abort(404);
    	}

        $meeting->title = $request->title;
        $meeting->start_date = $request->start_date;
        $meeting->end_date = $request->end_date;
        $meeting->project_id = $request->project_id;
        $meeting->client_id = $request->client_id;
        $meeting->location = $request->location;
        $meeting->description = $request->description;

        $meeting->update();

        $meeting->members()->sync($request->members);

        return redirect()->route('meetings.index')
                         ->with('success', 'Meeting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meeting = Meeting::find($id);
    	if(!isset($meeting) || empty($meeting)) {
    		abort(404);
    	}

        $meeting->members()->sync([]);

        $meeting->delete();

        return redirect()->route('meetings.index')
                         ->with('success', 'Meeting deleted successfully');
    }

    public function changeMeetingStatus(Request $request, $meetingId)
    {
        $memberIds = [];
        $meeting = Meeting::with('members')->find($meetingId);
    	if(!isset($meeting) || empty($meeting)) {
    		abort(404);
    	}

        $meeting->status = $request->status;

        $meeting->update();
        
        if(count($meeting->members) > 0) {
            foreach($meeting->members as $member) {
                $memberIds[] = $member->id;
            }
        }

        // get users whom meeting is assigned
        $members = User::whereIn('id', $memberIds)->get();
        // notify members
        if(isset($members)) {
            Notification::send($members, new MeetingStatusNotification($meeting));
        }

        return redirect()->route('meetings.index')
                         ->with('success', 'Meeting status updated successfully');        
    }
}
