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
            ajaxURL:"/getDefects",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            tooltipsHeader:true,
            tooltipGenerationMode:"hover",
            tooltips:function(cell){
                //cell - cell component
                //function should return a string for the tooltip of false to hide the tooltip
                // cell.getColumn().getField() + " - " + cell.getValue()
                return cell.getValue(); //return cells "field - value";
            },
            columns:[  
                {title:"#", hozAlign:"left", formatter:"rownum", hozAlign:"left", vertAlign:"middle", width:70},               //define the table columns
                {title:"Name", field:"name",  hozAlign:"left", vertAlign:"middle", headerFilter:"input", widthGrow:4},
                {title:"Start Date", field:"start_date", hozAlign:"left", vertAlign:"middle", widthGrow: 2},
                {title:"End Date", field:"end_date", hozAlign:"left", vertAlign:"middle", widthGrow: 2},
                {title:"Assigned", field:"assigned", hozAlign:"left", vertAlign:"middle", formatter:"html", tooltipsHeader:true, widthGrow: 1},
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
                {title:"Status", field:"status", vertAlign:"middle", widthGrow:2, formatter:function(cell, formatterParams){
                    if(cell.getValue() === "assigned") {
                        return '<span class="badge badge-soft-info">Assigned</span>';
                    } else if(cell.getValue() === "open") {
                        return '<span class="badge badge-soft-success">Open</span>';
                    } else if(cell.getValue() === "in_progress") {
                        return '<span class="badge badge-soft-warning">In Progress</span>';
                    } else if(cell.getValue() === "solved") {
                        return '<span class="badge badge-soft-success">Solved</span>';
                    } else if(cell.getValue() === "re-open") {
                        return '<span class="badge badge-soft-success">Reopen</span>';
                    } else if(cell.getValue() === "closed") {
                        return '<span class="badge badge-soft-dark">Closed</span>';
                    } else {
                        return '<span class="badge badge-soft-warning">Deferred</span>';
                    }
                }},
                {title:"Action", field:"action", widthGrow:2, hozAlign:"left", vertAlign:"middle", formatter:function(cell, formatterParams){
                    return `<a href="/defects/${cell.getValue()}/edit"><i class="las la-pen text-secondary font-16 me-1"></i></a><a href="#"><i class="las la-trash-alt text-secondary font-16"></i></a>`;
                }},
            ],
        });
    </script>
@endsection