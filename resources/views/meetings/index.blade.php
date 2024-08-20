<?php
    use Carbon\Carbon;
?>
@extends('layouts.app')

@section('style')
    <link href="{{ asset('admin-assets/plugins/fullcalendar/main.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @if(session()->has('success'))
        <div class="alert alert-success fade show" role="alert">
            <strong>Welldone! </strong>
            {{ session()->get('success') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3">
                    @include('meetings.inc.meeting_stats_box', ['text' => 'Total Meetings', 'stats' => $stats['total_meetings'], 'icon' => 'calendar'])
                </div>
                <div class="col-lg-3">
                    @include('meetings.inc.meeting_stats_box', ['text' => 'Open Meetings', 'stats' => $stats['open_meetings'], 'icon' => 'calendar'])
                </div>
                <div class="col-lg-3">
                    @include('meetings.inc.meeting_stats_box', ['text' => 'In Progress Meetings', 'stats' => $stats['in_progress_meetings'], 'icon' => 'calendar'])
                </div>
                <div class="col-lg-3">
                    @include('meetings.inc.meeting_stats_box', ['text' => 'Completed Meetings', 'stats' => $stats['completed_meetings'], 'icon' => 'calendar'])
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-6">                      
                            <h4 class="card-title">Meetings</h4>             
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ url('meetings?view=list') }}" class="me-1">
                                <button type="button" class="btn btn-primary btn-sm">
                                    <i class="ti ti-list"></i> List View
                                </button>
                            </a>
                            <a href="{{ url('meetings?view=calendar') }}" class="me-1">
                                <button type="button" class="btn btn-primary btn-sm">
                                    <i class="ti ti-calendar"></i> Calendar View
                                </button>
                            </a>
                            <a href="{{ route('meetings.create') }}">
                                <button type="button" class="btn btn-primary btn-sm"><i class="ti ti-plus"></i> Add New</button>
                            </a>                         
                        </div><!--end col-->                             
                    </div>                                  
                </div><!--end card-header-->
                @if($view == null || $view == 'list')
                    <div class="card-body">
                        @if(count($meetings) > 0)
                            <div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 25%;">Title</th>
                                                <th style="width: 20%;">Meeting Stat Date</th>
                                                <th style="width: 20%;">Meeting End Date</th>
                                                <th style="width: 10%;" class="text-center">Hours</th>
                                                <th style="width: 10%;" class="text-left">Status</th>
                                                <th style="width: 15%;" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($meetings as $meeting)
                                                <tr>
                                                    <td>
                                                        {{ $meeting->title }}
                                                    </td>
                                                    <td>{{ Carbon::parse($meeting->start_date)->toDayDateTimeString() }}</td>
                                                    <td>{{ Carbon::parse($meeting->end_date)->toDayDateTimeString() }}</td>
                                                    <?php
                                                        $startTime = Carbon::parse($meeting->start_date);  
                                                    ?>
                                                    <td class="text-center">{{ number_format((float)$startTime->floatDiffInRealHours($meeting->end_date), 2, ':', '') }}</td>
                                                    <td class="text-left">
                                                        @if($meeting->status === "open")
                                                            <span class="badge badge-soft-info">Open</span>
                                                        @elseif($meeting->status === "in_progress")
                                                            <span class="badge badge-soft-warning">In Progress</span>
                                                        @elseif($meeting->status === "cancel")
                                                            <span class="badge badge-soft-danger">Cancel</span>
                                                        @elseif($meeting->status === "completed")
                                                            <span class="badge badge-soft-success">Completed</span>
                                                        @else
                                                            <span class="badge badge-soft-warning">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">     
                                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('meetings.edit', $meeting->id) }}">Edit</a>
                                                            <form 
                                                                action="{{ route('meetings.destroy', $meeting->id) }}" 
                                                                method="post"
                                                                onsubmit="return confirm('Are you sure?');"
                                                            >                             
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="dropdown-item border-0 bg-transparent">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#meetingModal-{{ $meeting->id }}" href="#">Change Status</a>
                                                        </div>
                                                        <div class="modal fade" id="meetingModal-{{ $meeting->id }}" tabindex="-1" role="dialog" aria-labelledby="meetingModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <form 
                                                                    method="POST" 
                                                                    class="needs-validation"             
                                                                    id="meeting-modal-form"
                                                                    action="{{ route('meetings.status.update', $meeting->id) }}"
                                                                    onsubmit="return confirm('Are you sure?');"
                                                                    novalidate
                                                                >
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h6 class="modal-title m-0" id="meetingModalLabel">Meeting Status</h6>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div><!--end modal-header-->
                                                                        <div class="modal-body">
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-12" style="text-align: left !important;">
                                                                                    <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                                                                    <input 
                                                                                        type="text" 
                                                                                        class="form-control" 
                                                                                        id="title" 
                                                                                        name="title"
                                                                                        placeholder="Enter event/meeting title"
                                                                                        value="{{ $meeting->title }}"
                                                                                        disabled
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-12" style="text-align: left !important;">
                                                                                    <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                                                                    <select 
                                                                                        class="form-select" 
                                                                                        aria-label="Select Status"
                                                                                        name="status"
                                                                                        id="status"
                                                                                        required
                                                                                    >
                                                                                        <option value="open" {{ $meeting->status == "open" ? 'selected' : '' }}>Open</option>
                                                                                        <option value="in_progress" {{ $meeting->status == "in_progress" ? 'selected' : '' }}>In Progress</option>
                                                                                        <option value="cancel" {{ $meeting->status == "cancel" ? 'selected' : '' }}>Cancel</option>
                                                                                        <option value="completed" {{ $meeting->status == "completed" ? 'selected' : '' }}>Completed</option>
                                                                                    </select>
                                                                                    <div class="invalid-feedback">
                                                                                        Status is a required field.
                                                                                    </div>
                                                                                </div><!--end col-->
                                                                            </div><!--end row-->                                                      
                                                                        </div><!--end modal-body-->
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-de-primary btn-sm">Update Status</button>
                                                                        </div><!--end modal-footer-->
                                                                    </div><!--end modal-content-->
                                                                </form>
                                                            </div><!--end modal-dialog-->
                                                        </div><!--end modal-->
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table> 
                                </div> 
                                <hr />
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('meetings.create') }}">
                                            <button class="btn btn-outline-light btn-sm px-4 ">+ Add New</button>
                                        </a>
                                    </div><!--end col-->      
                                    <div class="col-auto">
                                        {{ $meetings->links() }}
                                    </div> <!--end col-->                               
                                </div><!--end row-->       
                            </div>
                        @else
                            <p class="p-3 pb-0 text-danger">No meeting record found!</p>
                        @endif
                    </div><!--end card-body-->
                @else
                    <div class="card-body">
                        <div id='calendar'></div>
                        <div style='clear:both'></div>
                    </div>
                @endif
            </div><!--end card-->
        </div> <!-- end col -->
    </div> <!-- end row -->
    
@endsection

@section('script')

    <script src="{{ asset('admin-assets/plugins/fullcalendar/main.min.js') }}"></script>
    <script>
        var calendarData = "{{ $meetingCalendarData }}";
        var calendarDataa = JSON.parse(calendarData.replace(/&quot;/g,'"'));

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                defaultDate: "{{ date('Y-m-d') }}",
                timeZone: 'UTC',
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                events: calendarDataa
            });

            calendar.render();
        });
    </script>

@endsection











