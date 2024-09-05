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
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h4 class="card-title">Todo List</h4>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('todos.create') }}">
                                <button type="button" class="btn btn-primary btn-sm">Add New Todo</button>
                            </a>                         
                        </div><!--end col-->
                    </div>
                </div>
                <div class="card-body">
                    <div class="kanban-board">
                        <div class="kanban-col">
                            <div class="kanban-main-card">
                                @include('todos.inc.kanban_title_box', ['title' => 'Open Todo'])
                                <div id="project-list-left" class="pb-1">
                                    @if(count($openTodos) > 0)
                                        @foreach($openTodos as $open)
                                            @include('todos.inc.kanban_project_box', ['todo' => $open])
                                        @endforeach
                                    @else
                                        <p>No todo found!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="kanban-col">
                            <div class="kanban-main-card">
                                @include('todos.inc.kanban_title_box', ['title' => 'Completed Todo'])
                                <div id="project-list-left" class="pb-1">
                                    @if(count($completedTodos) > 0)
                                        @foreach($completedTodos as $complete)
                                            @include('todos.inc.kanban_project_box', ['todo' => $complete])
                                        @endforeach
                                    @else
                                        <p>No todo found!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection










