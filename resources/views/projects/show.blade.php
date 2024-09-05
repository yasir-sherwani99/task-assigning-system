<?php
    use Illuminate\Support\Carbon;
?>
@extends('layouts.app')

@section('style')
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <p class="text-start mt-2 mb-1 fw-semibold">
                        Project Progress {{ $project->progress }}% completed
                    </p>
                    <div class="progress mb-3" style="height: 6px;">
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
                </div><!--end card-header-->
                <div class="card-body">
                    <h6 class="fw-bold">Overview</h6>
                    <div class="table-responsive mb-2">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="w-50">
                                        <p class="fw-semibold mb-0">Project #</p>
                                        <span class="fw-normal">{{ $project->id }}</span>
                                    </td>
                                    <td class="fw-semibold w-50">
                                        <p class="fw-semibold mb-0">Invoice</p>
                                        <span class="fw-normal">{{ $project->invoice_no }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-50">
                                        <p class="fw-semibold mb-0">Customer</p>
                                        <a href="#" class="fw-normal link-primary">{{ isset($project->clients) ? $project->clients->company_name : 'N/A' }}</a>
                                    </td>
                                    <td class="fw-semibold w-50">
                                        <p class="fw-semibold mb-0">Status</p>
                                        <span class="fw-normal">{{ ucwords(Str::replace('_', ' ', $project->status)) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-50">
                                        <p class="fw-semibold mb-0">Start Date</p>
                                        <span class="fw-normal">{{ Carbon::parse($project->start_date)->toFormattedDateString() }}</span>
                                    </td>
                                    <td class="fw-semibold w-50">
                                        <p class="fw-semibold mb-0">Team</p>
                                        <span class="fw-normal">{{ isset($project->teams) ? $project->teams->name : 'N/A' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-50">
                                        <p class="fw-semibold mb-0">Demo Url</p>
                                        <span class="fw-normal">{{ $project->demo_url }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-50">
                                        <p class="fw-semibold mb-2">Assignees</p>
                                        @if(isset($project->teams)) 
                                            @if(isset($project->teams->members))
                                                <div class="img-group">
                                                    @foreach($project->teams->members as $key => $member) 
                                                        <a href="#" class="user-avatar" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $member->first_name . ' ' . $member->last_name }}">
                                                            <img src="{{ asset($member->photo) }}" alt="{{ $member->first_name }}" class="thumb-xs rounded-circle" />
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>    
                    </div> 
                    <h6 class="fw-bold">Description</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td class="w-100">
                                        {!! $project->description !!}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!--end col-->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $data['open_tasks'] . '/' . $data['total_tasks'] }} Open Tasks</h4>
                    <p class="text-start mt-2 mb-1 fw-semibold">
                        {{ $data['open_task_percentage'] }}% 
                    </p>
                    <div class="progress mb-3" style="height: 6px;">
                        <?php
                            if($data['open_task_percentage'] < "20") {
                                $progressColor = "bg-danger";
                            } elseif($data['open_task_percentage'] >= "20" && $data['open_task_percentage'] < "40") {
                                $progressColor = "bg-warning";
                            } elseif($data['open_task_percentage'] >= "40" && $data['open_task_percentage'] < "60") {
                                $progressColor = "bg-info";
                            } elseif($data['open_task_percentage'] >= "60" && $data['open_task_percentage'] < "80") {
                                $progressColor = "bg-primary";
                            } else {
                                $progressColor = "bg-success";
                            }
                        ?>
                        <div 
                            class="progress-bar {{ $progressColor }}" 
                            role="progressbar" 
                            style="width: {{ $data['open_task_percentage'] . '%;' }}" 
                            aria-valuenow="{{ $data['open_task_percentage'] }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100"
                        ></div>
                    </div>
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold w-50">Billing Type</td>
                                    <td class="w-50">{{ ucwords($project->billing_type) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Budget</td>
                                    <td>{{ $project->budget }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Estimate Hours</td>
                                    <td>{{ $project->estimated_hours }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Date Created</td>
                                    <td>{{ Carbon::parse($project->created_at)->toFormattedDateString() }}</td>
                                </tr>
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->
@endsection

@section('script')
@endsection
