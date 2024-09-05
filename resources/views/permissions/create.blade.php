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
                    <h4 class="card-title">Permission Info</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <form method="POST" class="needs-validation" action="{{ route('permissions.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="name" 
                                    name="name"
                                    placeholder="Enter permission name"
                                    required
                                />
                                <div class="invalid-feedback">
                                    Permission name is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="group_id" class="form-label fw-bold">Group <span class="text-danger">*</span></label>                                            
                                <select 
                                    class="form-select" 
                                    aria-label="Select Group"
                                    name="group_id"
                                    id="group_id"
                                    required
                                >
                                    <option value="">Select Group</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Group is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
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
@endsection
