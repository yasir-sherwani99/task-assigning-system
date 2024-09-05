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
                        <a href="{{ route('projects.show', $defect->project_id) }}" class="link-primary">{{ isset($defect->projects) ? $defect->projects->name : 'N/A' }}</a>
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
                    {!! $defect->description !!}
                </div>                                           
            </div><!--end card-body-->
        </div><!--end col-->
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h4 class="card-title">Defect Info</h4>
                    <p class="text-muted mb-0">
                        Created by <a href="#">{{ $defect->createdby->first_name . ' ' . $defect->createdby->last_name }}</a>
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ 'Created at ' . $defect->created_at }}"><i class="far fa-fw fa-clock"></i></span> 
                    </p>
                </div><!--end card-header-->
                <div class="card-body">
                    <ul class="list-unstyled mb-2">
                        <li class="mb-3 d-flex align-items-center">
                            <i data-feather="star" class="align-self-center icon-xs icon-dual me-2"></i> 
                            <b class="me-1">Status</b>: 
                            <select 
                                class="form-select ms-2" 
                                aria-label="Select Status"
                                name="status"
                                id="status-{{ $defect->id }}"
                                onchange="changeStatus({{ $defect->id }})"
                            >
                                <option value="open" {{ $defect->status == "open" ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $defect->status == "in_progress" ? 'selected' : '' }}>In Progress</option>
                                <option value="reopen" {{ $defect->status == "reopen" ? 'selected' : '' }}>Reopen</option>
                                <option value="assigned" {{ $defect->status == "assigned" ? 'selected' : '' }}>Assigned</option>
                                <option value="closed" {{ $defect->status == "closed" ? 'selected' : '' }}>Closed</option>
                                <option value="solved" {{ $defect->status == "solved" ? 'selected' : '' }}>Solved</option>
                                <option value="deferred" {{ $defect->status == "deferred" ? 'selected' : '' }}>Deferred</option>
                            </select>
                        </li>
                        <li class="mb-3">
                            <i data-feather="calendar" class="align-self-center icon-xs icon-dual me-1"></i> 
                            <b class="me-1">Start Date</b>: {{ $defect->start_date }}
                        </li>
                        <li class="mb-3">
                            <i data-feather="zap" class="align-self-center icon-xs icon-dual me-1"></i> 
                            <b class="me-1">Priority</b>: 
                            @if($defect->priority == "urgent")
                                <span class="text-danger">Urgent</span>
                            @elseif($defect->priority == "very_high")
                                <span class="text-warning">Very High</span>
                            @elseif($defect->priority == "high")
                                <span class="text-warning">High</span>
                            @elseif($defect->priority == "medium")
                                <span class="text-info">Medium</span>
                            @else
                                <span class="text-success">Low</span>
                            @endif
                        </li>
                        <li>
                            <i data-feather="clock" class="align-self-center icon-xs icon-dual me-1"></i> 
                            <b class="me-1">Estimated Hours</b>: {{ ucwords($defect->estimated_hours) }}
                        </li>                                        
                    </ul>
                    <hr />
                    <p>
                        This defect is assigned to you by <a href="#" class="link-primary">{{ $defect->createdby->first_name . ' ' . $defect->createdby->last_name }}</a>
                    </p>
                    <hr />
                    <ul class="list-unstyled mb-2">
                        <li class="mb-3 d-flex align-items-center">
                            <i data-feather="users" class="align-self-center icon-xs icon-dual me-2"></i> 
                            <b class="me-1">Assignees</b>
                        </li>
                        @if(isset($defect->assigned))
                            <div class="img-group">
                                <a class="user-avatar me-1" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $defect->assigned->first_name . ' ' . $defect->assigned->last_name }}">
                                    <img src="{{ asset($defect->assigned->photo) }}" alt="{{ $defect->assigned->first_name }}" class="rounded-circle thumb-sm" />
                                </a>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div><!--end row-->
@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script>
        function changeStatus(defectId)
        {
            let status = document.getElementById(`status-${defectId}`).value;
            let csrf = "{{ csrf_token() }}";
        
            fetch(`/defect/${defectId}/status`, {
                method: 'PUT',
                headers: {
                    "X-CSRF-Token": csrf,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ status: status })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
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
    </script>
@endsection