@extends('layouts.app')

@section('style')
@endsection

@section('content')

    @if(session()->has('success'))
        <div class="alert alert-success fade show" role="alert">
            <strong>Welldone! </strong>
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <h5 class="mt-0">The list of all tasks. <span class="badge badge-pink">6</span></h5>
                </li>
            </ul>
        </div><!--end col-->

        <div class="col-lg-6 text-end">
            <div class="text-end">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ url('tasks?view=table') }}">
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="ti ti-table"></i>
                                Table View
                            </button>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ url('tasks?view=grid') }}">
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="ti ti-grid-dots"></i>
                                Grid View
                            </button>
                        </a>
                    </li>
                    @permission('create-task')
                        <li class="list-inline-item">
                            <a href="{{ route('tasks.create') }}">
                                <button type="button" class="btn btn-primary btn-sm">
                                    <i class="ti ti-plus"></i>
                                    New Task
                                </button>
                            </a>
                        </li>
                    @endpermission
                </ul>
            </div>                            
        </div><!--end col-->
    </div><!--end row-->
                    
    @if($view == null || $view == 'table')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tasks</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="datatable-tasks"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @if(count($tasks) > 0)
                @foreach($tasks as $task)
                    <div class="col-lg-6">
                        @include('tasks.inc.task_box', ['task' => $task])
                    </div><!--end col-->
                @endforeach
            @else
                <div class="col-lg-12">
                    <p class="text-center text-danger">No task found!</p>
                </div><!--end col-->
            @endif
        </div><!--end row-->
        <div class="row mb-3">
            <div class="col">
                @permission('create-task')
                    <a href="{{ route('tasks.create') }}">
                        <button class="btn btn-outline-light btn-sm px-4 ">+ Add New</button>
                    </a>
                @endpermission
            </div><!--end col-->      
            <div class="col-auto">
                {{ $tasks->links() }}
            </div> <!--end col-->                               
        </div><!--end row-->
    @endif

@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/tabulator/tabulator.min.js') }}"></script>
    <script>
        let table = new Tabulator('#datatable-tasks', {
            ajaxURL:"/tasks-datatable",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            tooltipsHeader:true,
            tooltipGenerationMode:"hover",
        //    headerHozAlign: 
            columns:[  
                {title:"#", hozAlign:"left", formatter:"rownum", hozAlign:"left", vertAlign:"middle", width:70},               //define the table columns
                {title:"Name", field:"name",  hozAlign:"left", vertAlign:"middle", headerFilter:"input", formatter:"html", widthGrow:3},
                {title:"Status", field:"status", vertAlign:"middle", widthGrow:2, formatter:function(cell, formatterParams){
                    return `<select 
                                class="form-select" 
                                name="status"
                                id="status-${cell.getRow().getData().id}"
                                onchange="changeStatusTable(${cell.getRow().getData().id})"
                            >
                                <option value="open" ${cell.getValue() == "open" ? 'selected' : ''}>Open</option>
                                <option value="in_progress" ${cell.getValue() == "in_progress" ? 'selected' : ''}>In Progress</option>
                                <option value="on_hold" ${cell.getValue() == "on_hold" ? 'selected' : ''}>On Hold</option>
                                <option value="cancel" ${cell.getValue() == "cancel" ? 'selected' : ''}>Cancel</option>
                                <option value="completed" ${cell.getValue() == "completed" ? 'selected' : ''}>Completed</option>
                                <option value="waiting" ${cell.getValue() == "waiting" ? 'selected' : ''}>Waiting</option>
                            </select>`
                }},
                {title:"Start Date", field:"start_date",  hozAlign:"left", vertAlign:"middle", widthGrow:1},
                {title:"Assigned To", field:"assignees", hozAlign:"left", vertAlign:"middle", formatter:"html", widthGrow:2},
                {title:"Priority", field:"priority",  hozAlign:"left", vertAlign:"middle", widthGrow:1, formatter:function(cell, formatterParams){
                    if(cell.getValue() === "urgent") {
                        return '<span class="text-danger">Urgent</span>';
                    } else if(cell.getValue() === "very_high") {
                        return '<span class="text-danger">Very High</span>';
                    } else if(cell.getValue() === "high") {
                        return '<span class="text-warning">High</span>';
                    } else if(cell.getValue() === "medium") {
                        return '<span class="text-info">Medium</span>';
                    } else {
                        return '<span class="text-success">Low</span>';
                    }
                }},
                {title:"Action", field:"action", widthGrow:1, hozAlign:"left", vertAlign:"middle", formatter:function(cell, formatterParams){
                    return `@permission('edit-task')<a href="/tasks/${cell.getValue()}/edit"><i class="las la-pen text-secondary font-16 me-1"></i></a>@endpermission
                    @permission('delete-task')<a href="#" onclick="deleteTask(${cell.getValue()})"><i class="las la-trash-alt text-secondary font-16 me-1"></i></a>@endpermission
                    <a href="/tasks/${cell.getValue()}"><i class="las la-eye text-secondary font-16"></i></a>`;
                }},
            ],
        });
    </script>
    <script src="{{ asset('admin-assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script>
        function changeStatusTable(taskId)
        {
            let status = document.getElementById(`status-${taskId}`).value;
            let csrf = "{{ csrf_token() }}";
        
            fetch(`/task/${taskId}/status`, {
                method: 'PUT',
                headers: {
                    "X-CSRF-Token": csrf,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ status: status, request_type: 'api' })
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
        const changeStatus = (taskId) => {
            if(confirm('Are you sure')) {
                document.getElementById(`status_form-${taskId}`).submit();
            } 
        } 
    </script>
    <script>
        function deleteTask(taskId)
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
                    fetch(`/tasks2/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-Token": csrf,
                            "Content-Type": "application/json"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            table.deleteRow(data.task_id);
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
            })
        }
    </script>
@endsection