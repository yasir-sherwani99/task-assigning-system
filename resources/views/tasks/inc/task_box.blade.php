<?php
    use Carbon\Carbon;
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
                <span class="mx-1">{{ Str::limit($task->assigned->first_name, 5) }}</span> 
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="End Date"><i class="far fa-fw fa-clock"></i> {{ Carbon::parse($task->end_date)->toFormattedDateString() }}</span>
            </p>
            <h5 class="mt-0">{{ Str::limit($task->name, 25) }}</h5>
            @if(isset($task->description))
                <p class="text-muted mb-1">{!! Str::limit($task->description, 100) !!}</p>
            @endif
            <p class="text-muted text-end mb-1">15% Complete</p>
            <div class="progress mb-4" style="height: 4px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="img-group">
                    <a class="user-avatar user-avatar-group" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $task->assigned->first_name . ' ' . $task->assigned->last_name }}">
                        <img src="{{ $task->assigned->photo }}" alt="user" class="rounded-circle thumb-xs">
                    </a>    
                </div><!--end img-group--> 
                <ul class="list-inline mb-0 align-self-center">                                         
                    <li class="list-item d-inline-block me-1">
                        <form 
                            action="{{ route('tasks.status.update', $task->id) }}" 
                            method="post"
                            id="status_form-{{ $task->id }}"
                        >                             
                            @csrf
                            @method('put')
                            <select 
                                class="form-select" 
                                aria-label="Select Status"
                                name="status"
                                onchange="changeStatus({{ $task->id }})"
                            >
                                <option value="open" {{ $task->status == "open" ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $task->status == "progress" ? 'selected' : '' }}>In Progress</option>
                                <option value="on_hold" {{ $task->status == "hold" ? 'selected' : '' }}>On Hold</option>
                                <option value="cancel" {{ $task->status == "cancel" ? 'selected' : '' }}>Cancel</option>
                                <option value="completed" {{ $task->status == "completed" ? 'selected' : '' }}>Completed</option>
                                <option value="waiting" {{ $task->status == "waiting" ? 'selected' : '' }}>Waiting</option>
                            </select>
                        </form>
                    </li>                           
                    <!-- <li class="list-item d-inline-block me-2">
                        <a class="" href="#">
                            <i class="mdi mdi-format-list-bulleted text-success font-15"></i>
                            <span class="text-muted fw-bold">15/100</span>
                        </a>
                    </li>
                    <li class="list-item d-inline-block">
                        <a class="" href="#">
                            <i class="mdi mdi-comment-outline text-primary font-15"></i>
                            <span class="text-muted fw-bold">3</span>
                        </a>                                                                               
                    </li> -->
                    <li class="list-item d-inline-block">
                        <a class="ms-2" href="{{ route('tasks.edit', $task->id) }}">
                            <i class="mdi mdi-pencil-outline text-muted font-18"></i>
                        </a>                                                                               
                    </li>
                    <li class="list-item d-inline-block">                           
                        <form 
                            action="{{ route('tasks.destroy', $task->id) }}" 
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
                    <li class="list-item d-inline-block">
                        <a class="ms-1" href="{{ route('tasks.show', $task->id) }}">
                            <i class="mdi mdi-eye text-muted font-18"></i>
                        </a>                                                                               
                    </li>
                </ul>
            </div>                                        
        </div><!--end task-box-->
    </div><!--end card-body-->
</div><!--end card-->