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
                    <div class="row align-items-center">
                        <div class="col-lg-6">                      
                            <h4 class="card-title">User Notifications</h4>             
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('notifications.read') }}">
                                <button type="button" class="btn btn-primary btn-sm">
                                    Mark all as Read
                                </button>
                            </a>                         
                        </div><!--end col-->                             
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable-notifications"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/tabulator/tabulator.min.js') }}"></script>
    <script>
        let table = new Tabulator('#datatable-notifications', {
            ajaxURL:"/notifications-datatable",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            columns:[  
                {title:"#", hozAlign:"left", formatter:"rownum", width:70},               //define the table columns
                {title:"Notification", field:"message", headerFilter:"input", hozAlign:"left", vertAlign:"middle", formatter:"html", widthGrow: 5},
                {title:"Is Read", field:"is_read", hozAlign:"left", vertAlign:"middle", formatter:"tickCross", widthGrow: 1},
                {title:"Date", field:"date", hozAlign:"left", vertAlign:"middle", formatter:"date", widthGrow: 2},
            ],
        });
    </script>
@endsection














