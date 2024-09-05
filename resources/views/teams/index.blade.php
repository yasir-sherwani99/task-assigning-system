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
                    <h5 class="mt-0">Here the list of all available teams. <span class="badge badge-pink">6</span></h5>
                </li>
            </ul>
        </div><!--end col-->

        <div class="col-lg-6 text-end">
            <div class="text-end">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ url('teams?view=table') }}">
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="ti ti-table"></i>
                                Table View
                            </button>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ url('teams?view=grid') }}">
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="ti ti-grid-dots"></i>
                                Grid View
                            </button>
                        </a>
                    </li>
                    @permission('create-team')
                        <li class="list-inline-item">
                            <a href="{{ route('teams.create') }}">
                                <button type="button" class="btn btn-primary btn-sm">
                                    <i class="ti ti-plus"></i>
                                    Add Team
                                </button>
                            </a>
                        </li>
                    @endpermission
                </ul>
            </div>                            
        </div><!--end col-->
    </div><!--end row-->
                    
    @if($view == null || $view == 'grid')
        <div class="row">
            @if(count($teams) > 0)
                @foreach($teams as $team)
                    <div class="col-lg-4">
                        @include('teams.inc.team_box', ['team' => $team])
                    </div><!--end col-->
                @endforeach
            @else
                <div class="col-lg-12">
                    <p class="text-center text-danger">No team found!</p>
                </div><!--end col-->
            @endif
        </div><!--end row-->
        <div class="row mb-3">
            <div class="col">
                @permission('create-team')
                    <a href="{{ route('teams.create') }}">
                        <button class="btn btn-outline-light btn-sm px-4 ">+ Add New</button>
                    </a>
                @endpermission
            </div><!--end col-->      
            <div class="col-auto">
                {{ $teams->links() }}
            </div> <!--end col-->                               
        </div><!--end row-->
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Teams</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="datatable-teams"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/tabulator/tabulator.min.js') }}"></script>
    <script>
        let table = new Tabulator('#datatable-teams', {
            ajaxURL:"/teams-datatable",
            layout:"fitColumns",      //fit columns to width of table
            responsiveLayout:"collapse",  //hide columns that dont fit on the table
            pagination:"local",       //paginate the data
            paginationSize:10,         //allow 7 rows per page of data
            placeholder:"<h6>No Data Available</h6>",
            tooltipsHeader:true,
            tooltipGenerationMode:"hover",
            columns:[  
                {title:"#", hozAlign:"left", formatter:"rownum", hozAlign:"left", vertAlign:"middle", width:70},               //define the table columns
                {title:"Name", field:"name",  hozAlign:"left", vertAlign:"middle", headerFilter:"input", formatter:"textarea", widthGrow:4},
                {title:"Leader", field:"leader",  hozAlign:"left", vertAlign:"middle", formatter:"textarea", widthGrow:3},
                {title:"Members", field:"members", hozAlign:"left", vertAlign:"middle", formatter:"html", tooltipsHeader:true, widthGrow:4},
                {title:"Action", field:"action", widthGrow:2, hozAlign:"left", vertAlign:"middle", formatter:function(cell, formatterParams){
                    return `@permission('edit-team')<a href="/teams/${cell.getValue()}/edit"><i class="las la-pen text-secondary font-16 me-1"></i></a>@endpermission
                    @permission('delete-team')<a href="#" onclick="deleteTeam(${cell.getValue()})"><i class="las la-trash-alt text-secondary font-16"></i></a>@endpermission`;
                }},
            ],
        });
    </script>
    <script src="{{ asset('admin-assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script>
        function deleteTeam(teamId)
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
                    fetch(`/teams2/${teamId}`, {
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-Token": csrf,
                            "Content-Type": "application/json"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            table.deleteRow(data.team_id);
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