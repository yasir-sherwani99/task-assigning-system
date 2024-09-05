@extends('layouts.app')

@section('style')
    <style>
        .tabulator .tabulator-header .tabulator-col {
            background-color: #f1f5fa !important;
         }
    </style>
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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Defects</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable-defects"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/tabulator/tabulator.min.js') }}"></script>
    <script>
        let table = new Tabulator('#datatable-defects', {
            ajaxURL:"/defects-datatable",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            tooltipsHeader:true,
            tooltipGenerationMode:"hover",
            columns:[  
                {title:"#", hozAlign:"left", formatter:"rownum", hozAlign:"left", vertAlign:"middle", width:70},               //define the table columns
                {title:"Name", field:"name",  hozAlign:"left", vertAlign:"middle", headerFilter:"input", formatter:"html", widthGrow:4},
                {title:"Status", field:"status", vertAlign:"middle", widthGrow:2, formatter:function(cell, formatterParams){
                    return `<select 
                                class="form-select" 
                                name="status"
                                id="status-${cell.getRow().getData().id}"
                                onchange="changeStatusTable(${cell.getRow().getData().id})"
                            >
                                <option value="open" ${cell.getValue() == "open" ? 'selected' : ''}>Open</option>
                                <option value="in_progress" ${cell.getValue() == "in_progress" ? 'selected' : ''}>In Progress</option>
                                <option value="reopen" ${cell.getValue() == "reopen" ? 'selected' : ''}>Reopen</option>
                                <option value="assigned" ${cell.getValue() == "assigned" ? 'selected' : ''}>Assigned</option>
                                <option value="solved" ${cell.getValue() == "solved" ? 'selected' : ''}>Solved</option>
                                <option value="closed" ${cell.getValue() == "closed" ? 'selected' : ''}>Closed</option>
                                <option value="deferred" ${cell.getValue() == "deferred" ? 'selected' : ''}>Deferred</option>
                            </select>`
                }},
                {title:"Start Date", field:"start_date",  hozAlign:"left", vertAlign:"middle", widthGrow:2},
                {title:"Assigned To", field:"assigned", hozAlign:"left", vertAlign:"middle", formatter:"html", widthGrow:2},
                {title:"Priority", field:"priority", vertAlign:"middle", widthGrow:2, formatter:function(cell, formatterParams){
                    if(cell.getValue() === "urgent") {
                        return '<span class="badge badge-soft-danger">Urgent</span>';
                    } else if(cell.getValue() === "very_high"){
                        return '<span class="badge badge-soft-warning">Very High</span>';
                    } else if(cell.getValue() === "high"){
                        return '<span class="badge badge-soft-warning">High</span>';
                    } else if(cell.getValue() === "medium"){
                        return '<span class="badge badge-soft-info">Medium</span>';
                    } else {
                        return '<span class="badge badge-soft-success">Low</span>';
                    }
                }},
                {title:"Action", field:"action", widthGrow:2, hozAlign:"left", vertAlign:"middle", formatter:function(cell, formatterParams){
                    return `@permission('edit-defect')<a href="/defects/${cell.getValue()}/edit"><i class="las la-pen text-secondary font-16 me-1"></i></a>@endpermission
                    @permission('delete-defect')<a href="#" onclick="deleteDefect(${cell.getValue()})"><i class="las la-trash-alt text-secondary font-16 me-1"></i></a>@endpermission
                    <a href="/defects/${cell.getValue()}"><i class="las la-eye text-secondary font-16"></i></a>`;
                }},
            ],
        });
    </script>
    <script src="{{ asset('admin-assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script>
        function changeStatusTable(defectId)
        {
            let status = document.getElementById(`status-${defectId}`).value;
            let csrf = "{{ csrf_token() }}";
        
            fetch(`/defect/${defectId}/status`, {
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
        function deleteDefect(defectId)
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
                    fetch(`/defects/${defectId}`, {
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-Token": csrf,
                            "Content-Type": "application/json"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            table.deleteRow(data.defect_id);
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