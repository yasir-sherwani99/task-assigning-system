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
            ajaxURL:"/getClients",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            columns:[  
                {title:"#", hozAlign:"left", formatter:"rownum", width:70},               //define the table columns
                {title:"Name", field:"name", headerFilter:"input", formatter:"html", widthGrow:3},
                {title:"Company", field:"company", headerFilter:"input", hozAlign:"left", vertAlign:"middle", widthGrow: 3},
                {title:"Designation", field:"designation", hozAlign:"left", vertAlign:"middle", widthGrow: 2},
                {title:"Status", field:"status", vertAlign:"middle", widthGrow:2, formatter:function(cell, formatterParams){
                    if(cell.getValue() === "active") {
                        return '<span class="badge badge-soft-success">Active</span>';
                    } else {
                        return '<span class="badge badge-soft-danger">Inactive</span>';
                    }
                }},
                {title:"Action", field:"action", widthGrow:2, hozAlign:"left", vertAlign:"middle", formatter:function(cell, formatterParams){
                    return `<a href="/clients/${cell.getValue()}/edit"><i class="las la-pen text-secondary font-16 me-1"></i></a><a href="#"><i class="las la-trash-alt text-secondary font-16"></i></a>`;
                }},
            ],
        });
    </script>
@endsection