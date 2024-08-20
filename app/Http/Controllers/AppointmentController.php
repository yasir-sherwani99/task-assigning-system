<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
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
        $appointments = Appointment::sort('desc')->paginate(10);

        $stats['total_appointment'] = Appointment::count();
        $stats['reserved_appointments'] = Appointment::open()->count();
        $stats['confirmed_appointments'] = Appointment::completed()->count();
        $stats['finished_appointments'] = Appointment::inProgress()->count();

        // if(count($meetings) > 0) {
        //     foreach($meetings as $meeting) {
                
        //         if($meeting->status == "open") {
        //             $className = "bg-soft-info";
        //         } elseif($meeting->status == "in_progress") {
        //             $className = "bg-soft-warning";
        //         } elseif($meeting->status == "cancel") {
        //             $className = "bg-soft-danger";
        //         } else {
        //             $className = "bg-soft-success";
        //         }

        //         $meetingData['title'] = $meeting->title;
        //         $meetingData['start'] = $meeting->start_date;
        //         $meetingData['end'] = $meeting->end_date;
        //      //   $meetingData['date'] = Carbon::parse($meeting->start_date)->toDayDateTimeString();
        //         $meetingData['className'] = $className;
        //         $meetingData['textColor'] = '#303e67';
        //      //   $meetingData['status'] = $meeting->status;

        //         $meetingWrapper[] = $meetingData;
        //     }
        // }

        // $meetingCalendarData = json_encode($meetingWrapper);

        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("Appointment List", "Appointments", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('appointments.index', compact('meetings', 'stats', 'view', 'meetingCalendarData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
