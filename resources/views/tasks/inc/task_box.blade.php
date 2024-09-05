<?php
    use Illuminate\Support\Carbon;
?>
<div class="card">
    <div class="card-body">                                    
        <div class="task-box">
            <div class="task-priority-icon">
                <i class="fas fa-circle text-success"></i>
            </div>
            <p class="text-muted float-right">
                @if($task->priority == "urgent")
                    <span class="badge bg-danger me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Priority">Urgent</span>
                @elseif($task->priority == "very_high")
                    <span class="badge bg-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Priority">Very High</span>
                @elseif($task->priority == "high")
                    <span class="badge bg-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Priority">High</span>
                @elseif($task->priority == "medium")
                    <span class="badge bg-info me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Priority">Medium</span>
                @else
                    <span class="badge bg-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Priority">Low</span>
                @endif
                @if(isset($task->estimated_hours))
                    <span class="text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Estimated Hours">{{ $task->estimated_hours }}</span>
                @endif
                <span class="mx-1">.</span> 
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="End Date"><i class="far fa-fw fa-clock"></i> {{ Carbon::parse($task->end_date)->toFormattedDateString() }}</span>
            </p>
            <h5 class="my-0 link-primary">{{ $task->name }}</h5>
            @if(isset($task->projects))
                <p class="mt-0 mb-1">#{{ $task->projects->id }} - {{ $task->projects->name }}</p>
            @else
                <p class="mt-0 mb-1">Project N/A</p>
            @endif
            <p class="text-muted text-end mb-1">
                {{ $task->progress }}% Completed
                <a class="ms-2" href="#" data-bs-toggle="modal" data-bs-target="#taskModal-{{ $task->id }}">
                    <i class="mdi mdi-pencil-outline text-muted font-18" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Task Progress"></i>
                </a>
            </p>
            <div class="progress mb-4" style="height: 4px;">
                <?php
                    if($task->progress < "20") {
                        $progressColor = "bg-danger";
                    } elseif($task->progress >= "20" && $task->progress < "40") {
                        $progressColor = "bg-warning";
                    } elseif($task->progress >= "40" && $task->progress < "60") {
                        $progressColor = "bg-info";
                    } elseif($task->progress >= "60" && $task->progress < "80") {
                        $progressColor = "bg-primary";
                    } else {
                        $progressColor = "bg-success";
                    }
                ?>
                <div 
                    class="progress-bar {{ $progressColor }}" 
                    role="progressbar" 
                    style="width: {{ $task->progress . '%;' }}" 
                    aria-valuenow="{{ $task->progress }}" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                ></div>
            </div>
            <div class="d-flex justify-content-between">
                @include('common.team_members_section', ['teamMembers' => isset($task->members) ? $task->members : null])
                <ul class="list-inline mb-0 align-self-center">                                         
                    <li class="list-item d-inline-block me-1">
                        <form 
                            action="{{ route('tasks.status.update', $task->id) }}" 
                            method="post"
                            id="status_form-{{ $task->id }}"
                        >                             
                            @csrf
                            @method('put')
                            <input type="hidden" name="request_type" value="web" />
                            <select 
                                class="form-select" 
                                aria-label="Select Status"
                                name="status"
                                onchange="changeStatus({{ $task->id }})"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="Status"
                            >
                                <option value="open" {{ $task->status == "open" ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $task->status == "in_progress" ? 'selected' : '' }}>In Progress</option>
                                <option value="on_hold" {{ $task->status == "on_hold" ? 'selected' : '' }}>On Hold</option>
                                <option value="cancel" {{ $task->status == "cancel" ? 'selected' : '' }}>Cancel</option>
                                <option value="completed" {{ $task->status == "completed" ? 'selected' : '' }}>Completed</option>
                                <option value="waiting" {{ $task->status == "waiting" ? 'selected' : '' }}>Waiting</option>
                            </select>
                        </form>
                    </li>
                    @permission('edit-task')                           
                        <li class="list-item d-inline-block">
                            <a class="ms-2" href="{{ route('tasks.edit', $task->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                <i class="mdi mdi-pencil-outline text-muted font-18"></i>
                            </a>                                                                               
                        </li>
                    @endpermission
                    @permission('delete-task')
                        <li class="list-item d-inline-block">                           
                            <form 
                                action="{{ route('tasks.destroy', $task->id) }}" 
                                method="post"
                                onsubmit="return confirm('Are you sure?');"
                            >                             
                                @csrf
                                @method('delete')   
                                <button type="submit" class="border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="mdi mdi-trash-can-outline text-muted font-18"></i>
                                </button>
                            </form>                                                    
                        </li>
                    @endpermission
                    @permission('view-tasks')
                        <li class="list-item d-inline-block">
                            <a class="ms-1" href="{{ route('tasks.show', $task->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                <i class="mdi mdi-eye text-muted font-18"></i>
                            </a>                                                                               
                        </li>
                    @endpermission
                </ul>
            </div>                                        
        </div><!--end task-box-->
    </div><!--end card-body-->
</div><!--end card-->
<div class="modal fade" id="taskModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalDefaultLabel">Task Progress</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->
            <div class="modal-body">
                <form 
                    action="{{ route('tasks.progress.update', $task->id) }}" 
                    method="post"
                >                             
                    @csrf
                    @method('put')
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="progress" class="form-label fw-bold">{{ $task->name }}</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="progress" class="form-label fw-bold">Task Progress <span class="text-danger">*</span></label>
                            <select 
                                class="form-select" 
                                aria-label="Select Progress"
                                name="progress"
                                id="progress"
                                required
                            >
                                <option value="{{ $task->progress }}">{{ $task->progress . '% Completed' }}</option>
                                <option value="5">5% Completed</option>
                                <option value="10">10% Completed</option>
                                <option value="15">15% Completed</option>
                                <option value="20">20% Completed</option>
                                <option value="25">25% Completed</option>
                                <option value="30">30% Completed</option>
                                <option value="35">35% Completed</option>
                                <option value="40">40% Completed</option>
                                <option value="45">45% Completed</option>
                                <option value="50">50% Completed</option>
                                <option value="55">55% Completed</option>
                                <option value="60">60% Completed</option>
                                <option value="65">65% Completed</option>
                                <option value="70">70% Completed</option>
                                <option value="75">75% Completed</option>
                                <option value="80">80% Completed</option>
                                <option value="85">85% Completed</option>
                                <option value="90">90% Completed</option>
                                <option value="95">95% Completed</option>
                                <option value="100">100% Completed</option>
                            </select>
                            <div class="invalid-feedback">
                                Progress is a required field.
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->   
                    <div class="row my-1">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm">Update Progress</button>
                        </div>
                    </div>
                </form>                                                   
            </div><!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div><!--end modal-footer-->
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->