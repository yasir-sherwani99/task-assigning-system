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
                    <h4 class="card-title">Edit User</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <form method="POST" class="needs-validation" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="fom-group">
                                    <label for="avatar" class="form-label fw-bold">Photo</label>
                                    <img 
                                        src="{{ asset($user->photo) }}"
                                        alt="babystore.ae." 
                                        class="thumb-lg rounded mx-3"
                                        id="avatar"
                                    >
                                    <label class="btn btn-de-primary btn-sm text-light">
                                        Change Avatar 
                                        <input 
                                            type="file" 
                                            hidden
                                            accept="image/*" 
                                            id="imgInp" 
                                            name="photo"
                                            src="{{ $user->photo }}"
                                            onchange="imagePreview(event)"
                                        />
                                    </label>
                                </div>
                            </div>
                        </div><!--end form-group-->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="first_name" 
                                    name="first_name"
                                    placeholder="Enter first name"
                                    value="{{ $user->first_name }}"
                                    required
                                />
                                <div class="invalid-feedback">
                                    First name is a required field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="last_name" 
                                    name="last_name"
                                    placeholder="Enter last name"
                                    value="{{ $user->last_name }}"
                                    required
                                />
                                <div class="invalid-feedback">
                                    Last name is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input 
                                    type="email" 
                                    class="form-control text-muted" 
                                    id="email" 
                                    name="email"
                                    placeholder="Enter email"
                                    value="{{ $user->email }}"
                                    disabled
                                    required
                                />
                                <small class="text-muted">Email must be unique</small>
                                <div class="invalid-feedback">
                                    Email is a required field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold">Phone</label>
                                <input 
                                    type="tel" 
                                    class="form-control" 
                                    id="phone" 
                                    name="phone"
                                    placeholder="Enter phone"
                                    value="{{ $user->phone }}"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="address" class="form-label fw-bold">Address</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="address" 
                                    name="address"
                                    placeholder="Enter address"
                                    value="{{ $user->address }}"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="city" class="form-label fw-bold">City </label>
                                <input 
                                    type="text" 
                                    id="city"
                                    class="form-control"
                                    name="city"
                                    placeholder="Enter city"
                                    value="{{ $user->city }}"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label fw-bold">Country </label>
                                <input 
                                    type="text" 
                                    id="country"
                                    class="form-control"
                                    name="country"
                                    placeholder="Enter country"
                                    value="{{ $user->country }}"
                                />
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-check form-switch form-switch-success">
                                <input class="form-check-input" type="checkbox" name="active" id="activeSwitch" {{ $user->status == 'active' ? 'checked' : '' }} />
                                <label class="form-check-label" for="activeSwitch">Active</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </form>                                           
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
@endsection

@section('script')
    <script>
        let imagePreview = function(event) {
            let newImage = event.target.files[0];
            let imageExt = newImage.type;
            if(imageExt == "image/jpg" || imageExt == "image/png" || imageExt == "image/gif" || imageExt == "image/svg" || imageExt == "image/jpeg") {
                let imgPreview = document.getElementById('avatar');
                imgPreview.src = URL.createObjectURL(newImage);
            } else {
                alert('Only images allowed');
            } 
        };
    </script>
@endsection
