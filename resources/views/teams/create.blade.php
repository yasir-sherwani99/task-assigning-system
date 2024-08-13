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
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Team</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <form method="POST" class="needs-validation" action="{{ route('teams.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold">Team Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="name" 
                                    name="name"
                                    placeholder="Enter team name"
                                    required
                                    value="{{ old('name') }}"
                                />
                                <div class="invalid-feedback">
                                    Team name is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">                                
                                <label for="members" class="form-label fw-bold">Team Members <span class="text-danger">*</span></label>                                            
                                <select 
                                    class="form-select" 
                                    aria-label="Select team members"
                                    name="members[]"
                                    id="members"
                                    required
                                >
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Multiple select</small>
                                <div class="invalid-feedback">
                                    Team members is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">                                
                                <label for="leader_id" class="form-label fw-bold">Team Leader <span class="text-danger">*</span></label>                                            
                                <select 
                                    class="form-select" 
                                    aria-label="Select team leader"
                                    name="leader_id"
                                    id="leader_id"
                                    required
                                >
                                    <option value="">Select Team Leader</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Team leader is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Enter team description"
                                >{{ old('description') }}</textarea>
                                <small class="text-muted">Max 500 characters</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>                                           
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/select/selectr.min.js') }}"></script>
    <script>
        new Selectr('#members',{
            multiple: true,
            placeholder: 'Select Team Members...'
        });
    </script>
@endsection












