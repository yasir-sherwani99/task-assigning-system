<?php
    use Carbon\Carbon;
?>
<div class="card">
    <div class="card-body">                                        
        <div class="media mb-3">
            <img src="{{ asset($project->image) }}" alt="" class="thumb-md rounded-circle">                                      
            <div class="media-body align-self-center text-truncate ms-2">                                            
                <h4 class="m-0 fw-semibold text-dark font-16">{{ Str::limit($project->name, 25) }}</h4>   
                <p class="text-muted  mb-0 font-13"><span class="text-dark">Client : </span>{{ Str::limit($project->clients->first_name . ' ' . $project->clients->last_name, 25) }}</p>                                         
            </div><!--end media-body-->
        </div>   
        <div class="d-flex justify-content-between">  
            <h6 class="fw-semibold">Start : <span class="text-muted font-weight-normal"> {{ Carbon::parse($project->start_date)->toFormattedDateString() }}</span></h6>
            <h6 class="fw-semibold">Deadline : <span class="text-muted font-weight-normal"> {{ Carbon::parse($project->end_date)->toFormattedDateString() }}</span></h6>                          
        </div> 
        @if(isset($project->budget))
            <div class="mt-3">
                <h5 class="font-18 m-0">{{ $project->budget }}</h5>
                <p class="mb-0 fw-semibold">Total Budget</p>                                        
            </div>
        @endif
        <div> 
            @if(isset($project->description))
                <p class="text-muted mt-4 mb-1">{!! Str::limit($project->description, 100) !!}</p>
            @endif
            <div class="d-flex justify-content-between">
                <h6 class="fw-semibold">All Hours : <span class="text-muted font-weight-normal"> 530 / 281:30</span></h6>
                <h6 class="fw-semibold">
                    <!-- Today : 
                    <span class="text-muted font-weight-normal"> 2:45</span> -->
                    <?php
                        if(round(Carbon::now()->diffInDays(Carbon::parse($project->end_date), false), 0) > 5) {
                            $badge = 'badge badge-soft-info';
                        } else {
                            $badge = 'badge badge-soft-pink';
                        }
                    ?>
                    <span class="{{ $badge }} fw-semibold ms-2">
                        <i class="far fa-fw fa-clock"></i> {{ round(Carbon::now()->diffInDays(Carbon::parse($project->end_date), false), 0) }} days left
                    </span>
                </h6>
            </div>
            <p class="text-muted text-end mb-1">15% Complete</p>
            <div class="progress mb-4" style="height: 4px;">
                <div class="progress-bar bg-purple" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between">
                @include('common.team_members_section', ['teamMembers' => $project->teams->member]) 
                <ul class="list-inline mb-0 align-self-center">                                                                    
                    <li class="list-item d-inline-block me-1">
                        <form 
                            action="{{ route('projects.status.update', $project->id) }}" 
                            method="post"
                            id="status_form-{{ $project->id }}"
                        >                             
                            @csrf
                            @method('put')
                            <select 
                                class="form-select px-3" 
                                aria-label="Select Status"
                                name="status"
                                onchange="changeStatus({{ $project->id }})"
                            >
                                <option value="open" {{ $project->status == "open" ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $project->status == "in_progress" ? 'selected' : '' }}>In Progress</option>
                                <option value="on_hold" {{ $project->status == "on_hold" ? 'selected' : '' }}>On Hold</option>
                                <option value="cancel" {{ $project->status == "cancel" ? 'selected' : '' }}>Cancel</option>
                                <option value="completed" {{ $project->status == "completed" ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </li>
                    <li class="list-item d-inline-block">
                        <a href="{{ route('projects.edit', $project->id) }}" class="ms-2">
                            <i class="mdi mdi-pencil-outline text-muted font-18"></i>
                        </a>                                                                               
                    </li>
                    <li class="list-item d-inline-block">
                        <form 
                            action="{{ route('projects.destroy', $project->id) }}" 
                            method="post"
                            onsubmit="return confirm('Are you sure?');"
                        >                             
                            @csrf
                            @method('delete')   
                            <button type="submit" class="border-0 bg-transparent">
                                <i class="mdi mdi-trash-can-outline text-muted font-18"></i>
                            </button>
                        </form>                                                                             
                    </li>
                </ul>
            </div>                                        
        </div><!--end task-box-->                                                                  
    </div><!--end card-body-->
</div><!--end card-->