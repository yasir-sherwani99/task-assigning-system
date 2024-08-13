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
                    <h5 class="mt-0">The list of all tasks. <span class="badge badge-pink">6</span></h5>
                </li>
            </ul>
        </div><!--end col-->

        <div class="col-lg-6 text-end">
            <div class="text-end">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <div class="input-group">                               
                            <input type="text" id="example-input1-group2" name="example-input1-group2" class="form-control form-control-sm" placeholder="Search">
                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i></button>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ route('tasks.create') }}">
                            <button type="button" class="btn btn-primary btn-sm">Add New Task</button>
                        </a>
                    </li>
                </ul>
            </div>                            
        </div><!--end col-->
    </div><!--end row-->
                    
    <div class="row">
        @if(count($tasks) > 0)
            @foreach($tasks as $task)
                <div class="col-lg-4">
                    @include('tasks.inc.task_box', ['task' => $task])
                </div><!--end col-->
            @endforeach
        @else
            <div class="col-lg-12">
                <p class="text-center text-danger">No task found!</p>
            </div><!--end col-->
        @endif
    </div><!--end row-->

@endsection

@section('script')
    <script>
        const changeStatus = (taskId) => {
            if(confirm('Are you sure')) {
                document.getElementById(`status_form-${taskId}`).submit();
            } 
        } 
    </script>
@endsection