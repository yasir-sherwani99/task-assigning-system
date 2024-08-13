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
                    <h5 class="mt-0">Here the list of all available teams. <span class="badge badge-pink">6</span></h5>
                </li>
            </ul>
        </div><!--end col-->

        <div class="col-lg-6 text-end">
            <div class="text-end">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route('teams.create') }}">
                            <button type="button" class="btn btn-primary btn-sm">Add Team</button>
                        </a>
                    </li>
                </ul>
            </div>                            
        </div><!--end col-->
    </div><!--end row-->
                    
    <div class="row">
        @if(count($teams) > 0)
            @foreach($teams as $team)
                <div class="col-lg-4">
                    @include('teams.inc.team_box', ['team' => $team])
                </div><!--end col-->
            @endforeach
        @else
            <div class="col-lg-12">
                <p class="text-center text-danger">No team found!</p>
            </div><!--end col-->
        @endif
    </div><!--end row-->

@endsection

@section('script')
@endsection