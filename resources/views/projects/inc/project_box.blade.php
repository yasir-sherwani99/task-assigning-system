<?php
    use Illuminate\Support\Carbon;
?>
<div class="card">
    <div class="card-body">                                        
        <div class="media mb-3">
            <img src="{{ asset($project->image) }}" alt="" class="thumb-md rounded-circle">                                      
            <div class="media-body align-self-center text-truncate ms-2">                                            
                <h4 class="m-0 fw-semibold text-dark font-16">{{ Str::limit($project->name, 50) }}</h4>   
                <p class="text-muted  mb-0 font-13"><span class="text-dark">Client : </span>{{ isset($project->clients) ? Str::limit($project->clients->first_name . ' ' . $project->clients->last_name, 25) : 'N/A' }}</p>                                         
            </div><!--end media-body-->
        </div>   
        <div class="d-flex justify-content-between">  
            <h6 class="fw-semibold">Start : <span class="text-muted font-weight-normal"> {{ Carbon::parse($project->start_date)->toFormattedDateString() }}</span></h6>
            <h6 class="fw-semibold">Deadline : <span class="text-muted font-weight-normal"> {{ Carbon::parse($project->end_date)->toFormattedDateString() }}</span></h6>                          
        </div> 
        @if(isset($project->budget))
            <div class="mt-3">
                <h5 class="font-18 m-0">{{ $project->budget }}</h5>
                <p class="mb-0 fw-semibold">{{ $project->billing_type == "fixed" ? "Total Budget" : "Per Hour" }}</p>                                        
            </div>
        @endif
        <div> 
            @if(isset($project->description))
                <p class="text-muted mt-4 mb-1">{!! Str::limit(strip_tags($project->description), 150) !!}</p>
            @endif
            <div class="d-flex justify-content-between">
                <h6 class="fw-semibold">Estimated Hours : <span class="text-muted font-weight-normal">{{ $project->estimated_hours }}</span></h6>
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
            <p class="text-muted text-end mb-1">
                {{ $project->progress }}% Completed
            </p>
            <div class="progress mb-4" style="height: 4px;">
                <?php
                    if($project->progress < "20") {
                        $progressColor = "bg-danger";
                    } elseif($project->progress >= "20" && $project->progress < "40") {
                        $progressColor = "bg-warning";
                    } elseif($project->progress >= "40" && $project->progress < "60") {
                        $progressColor = "bg-info";
                    } elseif($project->progress >= "60" && $project->progress < "80") {
                        $progressColor = "bg-primary";
                    } else {
                        $progressColor = "bg-success";
                    }
                ?>
                <div 
                    class="progress-bar {{ $progressColor }}" 
                    role="progressbar" 
                    style="width: {{ $project->progress . '%;' }}" 
                    aria-valuenow="{{ $project->progress }}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                ></div>
            </div>
            <div class="d-flex justify-content-between">
                @include('common.team_members_section', ['teamMembers' => isset($project->teams) ? $project->teams->members : null]) 
                <ul class="list-inline mb-0 align-self-center">                                                                    
                    <li class="list-item d-inline-block me-1">
                        <form 
                            action="{{ route('projects.status.update', $project->id) }}" 
                            method="post"
                            id="status_form-{{ $project->id }}"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" 
                            title="Update Project Status"
                        >                             
                            @csrf
                            @method('put')
                            <input type="hidden" name="request_type" value="web" />
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
                    @permission('edit-project')
                        <li class="list-item d-inline-block">
                            <a href="{{ route('projects.edit', $project->id) }}" class="ms-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Project">
                                <i class="mdi mdi-pencil-outline text-muted font-18"></i>
                            </a>                                                                               
                        </li>
                    @endpermission
                    @permission('delete-project')
                        <li class="list-item d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Project">
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
                    @endpermission
                    @permission('view-projects')
                        <li class="list-item d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="View Project">
                            <a href="{{ route('projects.show', $project->id) }}">
                                <i class="mdi mdi-eye text-muted font-18"></i>
                            </a>                                                                               
                        </li>
                    @endpermission
                </ul>
            </div>                                        
        </div><!--end task-box-->                                                                  
    </div><!--end card-body-->
</div><!--end card-->