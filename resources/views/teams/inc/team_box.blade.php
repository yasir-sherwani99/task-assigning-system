<div class="card team-card">
    <div class="card-body">
        <div class="float-end">                                        
            <div class="dropdown d-inline-block">
                <a class="dropdown-toggle" id="dLabel1" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="las la-ellipsis-v font-24 text-muted"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel1">
                    @permission('edit-team')
                        <a class="dropdown-item" href="{{ route('teams.edit', $team->id) }}">Edit Team</a> 
                    @endpermission
                    @permission('delete-team')
                        <form 
                            action="{{ route('teams.destroy', $team->id) }}" 
                            method="post"
                            onsubmit="return confirm('Are you sure?');"
                        >                             
                            @csrf
                            @method('delete')
                            
                            <button type="submit" class="border-0 bg-transparent dropdown-item">
                                Delete team
                            </button>
                        </form>
                    @endpermission
                </div>
            </div>
        </div>                                                 
        <div class="media align-items-center">                                                
            <div class="img-group">
                <a class="user-avatar me-1" href="#">
                    <img src="{{ asset($team->leader->photo) }}" alt="user" class="rounded-circle thumb-md">
                    <span class="avatar-badge online"></span>
                </a>
            </div>                                                                           
            <div class="media-body ms-2 align-self-center">
                <h5 class="m-0">{{ $team->leader->first_name . ' ' . $team->leader->last_name  }}</h5>
                <p class="text-muted font-12 mb-0">Team Leader</p>                                            
            </div>                                                                           
        </div> 
        <h4 class="m-0 mt-3 font-13 mb-0 fw-semibold">{{ $team->name }}</h4>
        @if(isset($team->description))
            <p class="text-muted mb-0">{{ Str::limit($team->description, 100) }}</p>
        @endif
        <div class="mt-3 d-flex justify-content-between">
            @include('common.team_members_section', ['teamMembers' => $team->members])  
            <div class="align-self-center">
                <button type="button" class="btn btn-xs btn-light btn-round">View Details <i class="mdi mdi-arrow-right"></i></button>
            </div> 
        </div>                                          
    </div><!--end card-body-->
</div><!--end card-->