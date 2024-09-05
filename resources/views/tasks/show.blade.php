<?php
    use Illuminate\Support\Carbon;
?>
@extends('layouts.app')

@section('style')
@endsection

@section('content')
    
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <h5 class="mt-0 lead">
                        Related:  
                        <a href="{{ route('projects.show', $task->project_id) }}" class="link-primary">{{ isset($task->projects) ? $task->projects->name : 'N/A' }}</a>
                    </h5>
                </li>
            </ul>
        </div><!--end col-->
    </div><!--end row-->

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Description</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    {!! $task->description !!}
                </div>                                           
            </div><!--end card-body-->
        </div><!--end col-->
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h4 class="card-title">Task Info</h4>
                    <p class="text-muted mb-0">
                        Created by <a href="#">{{ $task->createdby->first_name . ' ' . $task->createdby->last_name }}</a>
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ 'Created at ' . $task->created_at }}"><i class="far fa-fw fa-clock"></i></span> 
                    </p>
                </div><!--end card-header-->
                <div class="card-body">
                    <ul class="list-unstyled mb-2">
                        <li class="mb-3 d-flex align-items-center">
                            <i data-feather="star" class="align-self-center icon-xs icon-dual me-2"></i> 
                            <b class="me-1">Status</b>: 
                            <form 
                                action="{{ route('tasks.status.update', $task->id) }}" 
                                method="post"
                                id="status_form"
                                class="ms-2"
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
                                    <option value="in_progress" {{ $task->status == "in_progress" ? 'selected' : '' }}>In Progress</option>
                                    <option value="on_hold" {{ $task->status == "on_hold" ? 'selected' : '' }}>On Hold</option>
                                    <option value="cancel" {{ $task->status == "cancel" ? 'selected' : '' }}>Cancel</option>
                                    <option value="completed" {{ $task->status == "completed" ? 'selected' : '' }}>Completed</option>
                                    <option value="waiting" {{ $task->status == "waiting" ? 'selected' : '' }}>Waiting</option>
                                </select>
                            </form>
                        </li>
                        <li class="mb-3">
                            <i data-feather="calendar" class="align-self-center icon-xs icon-dual me-1"></i> 
                            <b class="me-1">Start Date</b>: {{ $task->start_date }}
                        </li>
                        <li class="mb-3">
                            <i data-feather="zap" class="align-self-center icon-xs icon-dual me-1"></i> 
                            <b class="me-1">Priority</b>: 
                            @if($task->priority == "urgent")
                                <span class="text-danger">Urgent</span>
                            @elseif($task->priority == "very_high")
                                <span class="text-warning">Very High</span>
                            @elseif($task->priority == "high")
                                <span class="text-warning">High</span>
                            @elseif($task->priority == "medium")
                                <span class="text-info">Medium</span>
                            @else
                                <span class="text-success">Low</span>
                            @endif
                        </li>
                        <li>
                            <i data-feather="clock" class="align-self-center icon-xs icon-dual me-1"></i> 
                            <b class="me-1">Estimated Hours</b>: {{ ucwords($task->estimated_hours) }}
                        </li>                                        
                    </ul>
                    <hr />
                    <p>
                        This task is assigned to you by <a href="#" class="link-primary">{{ $task->createdby->first_name . ' ' . $task->createdby->last_name }}</a>
                    </p>
                    <hr />
                    <ul class="list-unstyled mb-2">
                        <li class="mb-3 d-flex align-items-center">
                            <i data-feather="users" class="align-self-center icon-xs icon-dual me-2"></i> 
                            <b class="me-1">Assignees</b>
                        </li>
                        @if(isset($task->members))
                            <div class="img-group">
                                @foreach($task->members as $member)
                                    <a class="user-avatar me-1" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $member->first_name . ' ' . $member->last_name }}">
                                        <img src="{{ asset($member->photo) }}" alt="{{ $member->first_name }}" class="rounded-circle thumb-sm" />
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div><!--end row-->
@endsection

@section('script')
    <script>
        const changeStatus = (taskId) => {
            if(confirm('Are you sure')) {
                document.getElementById('status_form').submit();
            } 
        } 
    </script>
@endsection