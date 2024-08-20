<?php
    use Carbon\Carbon;
?>
@extends('layouts.app')

@section('style')
@endsection

@section('content')

    @if(count($errors) > 0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Task Info</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold w-25">Task Name</td>
                                    <td class="w-75">{{ $task->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Assigned To</td>
                                    <td>{{ $task->assigned->first_name . ' ' . $task->assigned->last_name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Project</td>
                                    <td>{{ $task->projects->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Estimate Hours</td>
                                    <td>{{ $task->estimated_hours }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Priority</td>
                                    <td>
                                        @if($task->priority == "urgent")
                                            <span class="badge bg-danger">Urgent</span>
                                        @elseif($task->priority == "very_high")
                                            <span class="badge bg-warning">Very High</span>
                                        @elseif($task->priority == "high")
                                            <span class="badge bg-warning">High</span>
                                        @elseif($task->priority == "medium")
                                            <span class="badge bg-info">Medium</span>
                                        @else
                                            <span class="badge bg-success">Low</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Status</td>
                                    <td>
                                        @if($task->status == "open")
                                            <span class="badge bg-info">Open</span>
                                        @elseif($task->status == "in_progress")
                                            <span class="badge bg-warning">In Progress</span>
                                        @elseif($task->status == "on_hold")
                                            <span class="badge bg-warning">On Hold</span>
                                        @elseif($task->status == "cancel")
                                            <span class="badge bg-dark">Cancel</span>
                                        @elseif($task->status == "completed")
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-secondary">Waiting</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Task Dates</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold w-25">Start Date</td>
                                    <td class="w-75">{{ Carbon::parse($task->start_date)->toFormattedDateString() }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">End Date</td>
                                    <td>{{ Carbon::parse($task->end_date)->toFormattedDateString() }}</td>
                                </tr>
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Task Description</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    {!! $task->description !!}
                </div>                                           
            </div><!--end card-body-->
        </div><!--end col-->
    </div><!--end row-->
@endsection

@section('script')
@endsection
