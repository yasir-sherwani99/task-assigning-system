@extends('layouts.app')

@section('style')
    <style>
        .tabulator .tabulator-header .tabulator-col {
            background-color: #f1f5fa !important;
        }
        #datatable-users {
            overflow: visible !important;
        }
        #datatable-users .tabulator-cell {
            overflow: visible !important;
        }
        #datatable-users .tabulator-tableholder {
            overflow: visible !important;
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
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h4 class="card-title">Users List</h4>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('users.create') }}">
                                <button type="button" class="btn btn-primary btn-sm">Add New User</button>
                            </a>                         
                        </div><!--end col-->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable-users"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/tabulator/tabulator.min.js') }}"></script>
    <script>
        let table = new Tabulator('#datatable-users', {
            ajaxURL:"/users-datatable",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            columns:[  
                {title:"#", hozAlign:"left", formatter:"rownum", width:70},               //define the table columns
                {title:"Name", field:"name", headerFilter:"input", formatter:"html", widthGrow:3},
                {title:"Roles", field:"roles", headerFilter:"input", vertAlign:"middle", formatter:"html", widthGrow:3},
                {title:"Email", field:"email", hozAlign:"left", vertAlign:"middle", widthGrow: 3},
              //  {title:"Phone", field:"phone", hozAlign:"left", widthGrow: 3},
                {title:"Status", field:"status", vertAlign:"middle", widthGrow:2, formatter:function(cell, formatterParams){
                    if(cell.getValue() === "active") {
                        return '<span class="badge-soft-success badge me-2">Active</span>';
                    } else {
                        return '<span class="badge-soft-danger badge me-2">Blocked</span>';
                    }
                }},
                {title:"Action", field:"action", widthGrow:2, hozAlign:"left", vertAlign:"middle", formatter:function(cell, formatterParams){
                   // return `<a href="/users/${cell.getValue()}/edit"><i class="las la-pen text-secondary font-16 me-1"></i></a><a href="#" onclick="deleteRow(${cell.getValue()})"><i class="las la-trash-alt text-secondary font-16"></i></a>`;
                    return `<div class="dropdown d-inline-block">
                                <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="las la-ellipsis-v font-20 text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                    <a class="dropdown-item" href="/users/${cell.getValue()}/edit">Edit User</a>
                                    <a class="dropdown-item" href="#">Delete User</a>
                                    <a class="dropdown-item" href="/user/role-permissions/${cell.getValue()}/edit">Edit Role & Permissions</a>
                                </div>
                            </div>`
                }},
            ],
        });
    </script>
@endsection