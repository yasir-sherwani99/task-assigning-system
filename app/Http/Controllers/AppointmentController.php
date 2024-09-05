<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Client;
use App\Models\Appointment;
use App\Traits\BreadcrumbTrait;
use App\Http\Requests\AppointmentStoreRequest;
use App\Notifications\AppointmentStatusNotification;
use App\Notifications\NewAppointmentNotification;

class AppointmentController extends Controller
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
        $appointmentData = [];
        $appointmentWrapper = [];
        $appointments = Appointment::sort('desc')->get();

        $stats['total_appointment'] = Appointment::count();
        $stats['reserved_appointments'] = Appointment::reserved()->count();
        $stats['confirmed_appointments'] = Appointment::confirmed()->count();
        $stats['finished_appointments'] = Appointment::finished()->count();

        if(count($appointments) > 0) {
            foreach($appointments as $appointment) {
                
                if($appointment->status == "reserved") {
                    $className = "bg-soft-info";
                } elseif($appointment->status == "confirmed") {
                    $className = "bg-soft-warning";
                } elseif($appointment->status == "canceled") {
                    $className = "bg-soft-danger";
                } else {
                    $className = "bg-soft-success";
                }

                $appointmentData['title'] = $appointment->title;
                $appointmentData['start'] = $appointment->start_date;
                $appointmentData['end'] = $appointment->end_date;
                $appointmentData['className'] = $className;
                $appointmentData['textColor'] = '#303e67';

                $appointmentWrapper[] = $appointmentData;
            }
        }

        $appointmentCalendarData = json_encode($appointmentWrapper);

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Appointment List", "Appointments", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('appointments.index', compact('appointments', 'stats', 'view', 'appointmentCalendarData'));
    }

    public function getAppointments()
    {
        $appointmentArray = [];
        $appointments = Appointment::with(['users', 'clients'])->sort('desc')->get();
        
        if(count($appointments) > 0) {
            foreach($appointments as $appointment) {
                $clientName = isset($appointment->clients) ? $appointment->clients->first_name . ' ' . $appointment->clients->last_name : "Client N/A";
                $appointmentName = "<div class='media'><div class='media-body align-self-center text-truncate'><h6 class='mt-0 mb-1 link-primary'>{$appointment->title}</h6><p class='mb-0'><b>Client</b>: {$clientName}</p></div></div>";
                $userName = $appointment->users->first_name . ' ' . $appointment->users->last_name;
                $user = "<a href=\"#\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"{$userName}\"><img src=\"{$appointment->users->photo}\" class=\"rounded-circle thumb-sm\" /></a>";

                $appointmentArray[] = [
                    'id' => $appointment->id,
                    'name' => $appointmentName, 
                    'start_date' => Carbon::parse($appointment->start_date)->toDayDateTimeString(),
                    'assigned' => $user,
                    'status' => $appointment->status,
                    'action' =>  $appointment->id
                ];
            }
        }

        return json_encode($appointmentArray);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $clients = Client::all();
        
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Appointment Create", "Appointments", "Create");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('appointments.create', compact('users', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentStoreRequest $request)
    {
        $appointment = new Appointment();

        $appointment->title = $request->title;
        $appointment->organizer_id = $request->user_id;
        $appointment->client_id = $request->client_id;
        $appointment->start_date = $request->start_date;
        $appointment->end_date = $request->end_date;
        $appointment->location = $request->location;
        $appointment->notes = $request->notes;
        $appointment->status = 'reserved';

        $appointment->save();

        // get user with appointment is set
        $user = User::find($request->user_id);
        // notify users
        if(isset($user)) {
            $user->notify(new NewAppointmentNotification($appointment));
        }

        return redirect()->route('appointments.index')
                         ->with('success', 'New appointment created successfully');
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
        $appointment = Appointment::with(['users', 'clients'])->find($id);
        if(!isset($appointment) || empty($appointment)) {
    		abort(404);
    	}

        $users = User::all();
        $clients = Client::all();
        
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Appointment Edit", "Appointments", "Edit");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('appointments.edit', compact('appointment', 'users', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentStoreRequest $request, string $id)
    {
        $appointment = Appointment::with(['users', 'clients'])->find($id);
        if(!isset($appointment) || empty($appointment)) {
    		abort(404);
    	}

        $appointment->title = $request->title;
        $appointment->organizer_id = $request->user_id;
        $appointment->client_id = $request->client_id;
        $appointment->start_date = $request->start_date;
        $appointment->end_date = $request->end_date;
        $appointment->location = $request->location;
        $appointment->notes = $request->notes;

        $appointment->update();

        return redirect()->route('appointments.index')
                         ->with('success', 'An appointment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);
    	if(!isset($appointment) || empty($appointment)) {
    		return response()->json([
                'success' => false,
                'message' => 'Woops! The requested resource was not found!'
            ], 404);
    	}

        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Well done! Appointment deleted successfully.',
            'appointment_id' => $id
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function changeAppointmentStatus(Request $request, $appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
    	if(!isset($appointment) || empty($appointment)) {
    		return response()->json([
                'success' => false,
                'message' => 'Woops! The requested resource was not found!'
            ], 404);
    	}

        $appointment->status = $request->status;
        $appointment->update();
        
        // get organizer
        $organizer = User::find($appointment->organizer_id);
        // notify organizer
        if(isset($organizer)) {
            $organizer->notify(new AppointmentStatusNotification($appointment));
        }

        return response()->json([
            'success' => true,
            'message' => 'Well done! Appointment status updated successfully.'
        ], 200);
    }
}
















