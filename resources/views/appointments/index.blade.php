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
                    @include('common.stats_box', ['text' => 'Total', 'stats' => $stats['total_appointment'], 'icon' => 'calendar'])
                </div>
                <div class="col-lg-3">
                    @include('common.stats_box', ['text' => 'Reserved', 'stats' => $stats['reserved_appointments'], 'icon' => 'calendar'])
                </div>
                <div class="col-lg-3">
                    @include('common.stats_box', ['text' => 'Confirmed', 'stats' => $stats['confirmed_appointments'], 'icon' => 'calendar'])
                </div>
                <div class="col-lg-3">
                    @include('common.stats_box', ['text' => 'Finished', 'stats' => $stats['finished_appointments'], 'icon' => 'calendar'])
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
                            <h4 class="card-title">Appointments</h4>             
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ url('appointments?view=table') }}" class="me-1">
                                <button type="button" class="btn btn-outline-primary btn-sm">
                                    <i class="ti ti-list"></i> Table View
                                </button>
                            </a>
                            <a href="{{ url('appointments?view=calendar') }}" class="me-1">
                                <button type="button" class="btn btn-outline-primary btn-sm">
                                    <i class="ti ti-calendar"></i> Calendar View
                                </button>
                            </a>
                            @permission('create-appointment')
                                <a href="{{ route('appointments.create') }}">
                                    <button type="button" class="btn btn-primary btn-sm">
                                        <i class="ti ti-plus"></i> 
                                        Add New
                                    </button>
                                </a>
                            @endpermission                         
                        </div><!--end col-->                             
                    </div>                                  
                </div><!--end card-header-->
                @if($view == null || $view == 'table')
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="datatable-appointments"></div>
                        </div>
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
    <script src="{{ asset('admin-assets/plugins/tabulator/tabulator.min.js') }}"></script>
    <script>
        let table = new Tabulator('#datatable-appointments', {
            ajaxURL:"/appointments-datatable",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            tooltipsHeader:true,
            tooltipGenerationMode:"hover",
            columns:[  
                {title:"#", hozAlign:"left", formatter:"rownum", hozAlign:"left", vertAlign:"middle", width:70},               //define the table columns
                {title:"Title", field:"name",  hozAlign:"left", vertAlign:"middle", headerFilter:"input", formatter:"html", widthGrow:4},
                {title:"Status", field:"status", vertAlign:"middle", widthGrow:2, formatter:function(cell, formatterParams){
                    return `<select 
                                class="form-select" 
                                name="status"
                                id="status-${cell.getRow().getData().id}"
                                onchange="changeStatusTable(${cell.getRow().getData().id})"
                            >
                                <option value="reserved" ${cell.getValue() == "reserved" ? 'selected' : ''}>Reserved</option>
                                <option value="confirmed" ${cell.getValue() == "confirmed" ? 'selected' : ''}>Confirmed</option>
                                <option value="finished" ${cell.getValue() == "finished" ? 'selected' : ''}>Finished</option>
                                <option value="cancel" ${cell.getValue() == "cancel" ? 'selected' : ''}>Cancel</option>
                            </select>`
                }},
                {title:"Start Date", field:"start_date",  hozAlign:"left", vertAlign:"middle", formatter:"textarea", widthGrow:3},
                {title:"Assigned To", field:"assigned", hozAlign:"left", vertAlign:"middle", formatter:"html", widthGrow:2},
                {title:"Action", field:"action", widthGrow:2, hozAlign:"left", vertAlign:"middle", formatter:function(cell, formatterParams){
                    return `@permission('edit-appointment')<a href="/appointments/${cell.getValue()}/edit"><i class="las la-pen text-secondary font-16 me-1"></i></a>@endpermission
                    @permission('delete-appointment')<a href="#" onclick="deleteAppointment(${cell.getValue()})"><i class="las la-trash-alt text-secondary font-16"></i></a>@endpermission`;
                }},
            ],
        });
    </script>
    <script src="{{ asset('admin-assets/plugins/fullcalendar/main.min.js') }}"></script>
    <script>
        var calendarData = "{{ $appointmentCalendarData }}";
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
    <script src="{{ asset('admin-assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script>
        function changeStatusTable(appointmentId)
        {
            let status = document.getElementById(`status-${appointmentId}`).value;
            let csrf = "{{ csrf_token() }}";
        
            fetch(`/appointment/${appointmentId}/status`, {
                method: 'PUT',
                headers: {
                    "X-CSRF-Token": csrf,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ status: status })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message,
                    //   footer: '<a href>Why do I have this issue?</a>'
                    })
                }
            })
            .catch(error => {
                if(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Woops something went wrong!',
                    //   footer: '<a href>Why do I have this issue?</a>'
                    })
                }
            })   
        }
    </script>
    <script>
        function deleteAppointment(appointmentId)
        {
            let csrf = "{{ csrf_token() }}";
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then(function(result) {
                if (result.isConfirmed) {
                    fetch(`/appointments/${appointmentId}`, {
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-Token": csrf,
                            "Content-Type": "application/json"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            table.deleteRow(data.appointment_id);
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })
                        
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            })                
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.data.message,
                            //   footer: '<a href>Why do I have this issue?</a>'
                            })
                        }
                    })
                    .catch(error => {
                        if(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Woops something went wrong!',
                            //   footer: '<a href>Why do I have this issue?</a>'
                            })
                        }
                    })   
                }
            })
        }
    </script>
@endsection











