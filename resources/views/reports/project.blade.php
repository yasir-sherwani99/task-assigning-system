@extends('layouts.app')

@section('style')
    <style>
        .tabulator .tabulator-table .tabulator-cell {
            overflow: unset !important;
        }
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Project Report</h4>
                    </div>
                    @permission('download-reports')
                        <div>
                            <div class="button-items">
                                <button type="button" id="download-xlsx" class="btn btn-secondary"><i class="mdi mdi-arrow-down-bold me-2"></i>Download XLSX</button>
                                <button type="button" id="download-pdf" class="btn btn-secondary"><i class="mdi mdi-arrow-down-bold me-2"></i>Download PDF</button>
                            </div>
                        </div>
                    @endpermission
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable-project-report"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/tabulator/tabulator.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/tabulator/jspdf.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/tabulator/xlsx.full.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/tabulator/jspdf.plugin.autotable.js') }}"></script>
    <script>
        let table = new Tabulator('#datatable-project-report', {
            ajaxURL:"/report/project-datatable",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            columns:[  
                {title:"Invoice", field:"invoice", hozAlign:"left", vertAlign:"middle", widthGrow:1},               //define the table columns
                {title:"Name", field:"name", headerFilter:"input", hozAlign:"left", vertAlign:"middle", formatter:"textarea", widthGrow:2},
                {title:"Client", field:"client", headerFilter:"input", vertAlign:"middle", formatter:"textarea", widthGrow:2},
                {title:"Start", field:"start", hozAlign:"left", vertAlign:"middle", widthGrow: 1},
                {title:"End", field:"end", hozAlign:"left", vertAlign:"middle", widthGrow: 1},
                {title:"Hours", field:"hours", hozAlign:"left", vertAlign:"middle", widthGrow: 1},
            //    {title:"Assigned", field:"assigned", hozAlign:"left", vertAlign:"middle", formatter:"html", widthGrow: 3},
                {title:"Status", field:"status", vertAlign:"middle", widthGrow:1, formatter:function(cell, formatterParams){
                    if(cell.getValue() === "open") {
                        return '<span class="badge badge-soft-primary">Open</span>';
                    } else if(cell.getValue() === "in_progress") {
                        return '<span class="badge badge-soft-warning">In Progress</span>';
                    } else if(cell.getValue() === "on_hold") {
                        return '<span class="badge badge-soft-dark">On Hold</span>';
                    } else if(cell.getValue() === "cancel") {
                        return '<span class="badge badge-soft-danger">Cancel</span>';
                    } else {
                        return '<span class="badge badge-soft-success">Completed</span>';
                    }
                }},
                {title:"Billing", field:"billing", vertAlign:"middle", widthGrow:1, formatter:function(cell, formatterParams){
                    if(cell.getValue() === "hourly") {
                        return '<span class="badge badge-soft-dark">Hourly Rate</span>';
                    } else {
                        return '<span class="badge badge-soft-dark">Fixed Rate</span>';
                    }
                }},
                {title:"Budget", field:"budget", hozAlign:"left", vertAlign:"middle", widthGrow: 1},
            ],
            // downloadRowRange:"all",
            downloadConfig:{
                columnHeaders:true, //do not include column headers in downloaded table
                columnGroups:false, //do not include column groups in column headers for downloaded table
                rowGroups:true, //do not include row groups in downloaded table
                columnCalcs:true, //do not include column calcs in downloaded table
                dataTree:false, //do not include data tree in downloaded table
            },
        });

        //trigger download of orders.xlsx file
        document.getElementById("download-xlsx").addEventListener("click", function(){
            table.download("xlsx", "project_report.xlsx", {sheetName:"Projects"});
        });

        document.getElementById("download-pdf").addEventListener("click", function(){
            table.download("pdf", "project_report.pdf", {
                orientation:"portrait", //set page orientation to portrait
                title:"Projects", //add title to report
            });
        });
    </script>
@endsection

















