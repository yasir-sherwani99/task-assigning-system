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
                    <h4 class="card-title">Client List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable-clients"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/tabulator/tabulator.min.js') }}"></script>
    <script>
        let table = new Tabulator('#datatable-clients', {
            ajaxURL:"/clients-datatable",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            columns:[  
                {title:"#", hozAlign:"left", formatter:"rownum", widthGrow:1},               //define the table columns
                {title:"Name", field:"name", headerFilter:"input", formatter:"html", widthGrow:3},
                {title:"Company", field:"company", headerFilter:"input", hozAlign:"left", vertAlign:"middle", widthGrow: 3},
                {title:"Designation", field:"designation", hozAlign:"left", vertAlign:"middle", widthGrow: 3},
                @permission('edit-client')
                    {title:"Status", field:"status", vertAlign:"middle", widthGrow:1, formatter:function(cell, formatterParams){
                        if(cell.getValue() === "active") {
                            var status = 'checked';
                        } else {
                            var status = '';
                        }
                        return `<div class="form-check form-switch form-switch-success"><input class="form-check-input" type="checkbox" name="active" id="activeSwitch" ${status} onclick="changeStatus(${cell.getRow().getData().id})" /></div>`;
                    }},
                @endpermission
                {title:"Action", field:"action", widthGrow:1, hozAlign:"left", vertAlign:"middle", formatter:function(cell, formatterParams){
                    return `@permission('edit-client')<a href="/clients/${cell.getValue()}/edit"><i class="las la-pen text-secondary font-16 me-1"></i></a>@endpermission
                    @permission('delete-client')<a href="#" onclick="deleteClient(${cell.getValue()})"><i class="las la-trash-alt text-secondary font-16"></i></a>@endpermission`;
                }},
            ],
        });
    </script>
    <script>
        function changeStatus(clientId)
        {
            fetch(`/client/${clientId}/status`)
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
                });
        }
    </script>
    <script src="{{ asset('admin-assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script>
        function deleteClient(clientId)
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
                    fetch(`/clients/${clientId}`, {
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-Token": csrf,
                            "Content-Type": "application/json"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            table.deleteRow(data.client_id);
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














