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
                    <h4 class="card-title">Create User</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <form method="POST" class="needs-validation" action="{{ route('users.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="fom-group">
                                    <label for="avatar" class="form-label fw-bold">Photo</label>
                                    <img 
                                        src="{{ asset('admin-assets/images/users/user-vector.png') }}" 
                                        alt="babystore.ae." 
                                        class="thumb-lg rounded mx-3"
                                        id="avatar"
                                        onerror="this.onerror=null;this.src='{{ asset('admin-assets/images/users/user-vector.png') }}'" 
                                    >
                                    <label class="btn btn-de-primary btn-sm text-light">
                                        Change Avatar 
                                        <input 
                                            type="file" 
                                            hidden
                                            accept="image/*" 
                                            id="imgInp" 
                                            name="photo"
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
                                    value="{{ old('first_name') }}"
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
                                    value="{{ old('last_name') }}"
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
                                    class="form-control" 
                                    id="email" 
                                    name="email"
                                    placeholder="Enter email"
                                    value="{{ old('email') }}"
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
                                    value="{{ old('phone') }}"
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
                                    value="{{ old('address') }}"
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
                                    value="{{ old('city') }}"
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
                                    value="{{ old('country') }}"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="password" 
                                    name="password"
                                    placeholder="Enter password"
                                    required
                                    value="{{ old('password') }}"
                                />
                                <small class="text-muted">Password must be 6 characters or greater</small>
                                <div class="invalid-feedback">
                                    Password is a required field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
                                <input 
                                    type="password" 
                                    id="password_confirmation"
                                    class="form-control"
                                    name="password_confirmation"
                                    placeholder="Reenter your password"
                                    required
                                    value="{{ old('password_confirmation') }}"
                                />
                                <div class="invalid-feedback">
                                    Confirm password is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="role_id" class="form-label fw-bold">Role <span class="text-danger">*</span></label>                                            
                                <select 
                                    class="form-select" 
                                    aria-label="Select Role"
                                    name="role_id"
                                    id="role_id"
                                    required
                                >
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Role is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold">Permissions <span class="text-danger">*</span></label>
                                @foreach($permissionArray as $permission)
                                    <div class="row my-2">
                                        <div class="col-md-3 fw-semibold">
                                            {{ $permission['name'] }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                @foreach($permission['group'] as $group)
                                                    <div class="col-md-3">
                                                        <label class="form-label">
                                                            <input type="checkbox" name="permission_id[]" value="{{ $group['id'] }}" class="me-1" /> {{ $group['name'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check form-switch form-switch-success">
                                <input class="form-check-input" type="checkbox" name="active" id="activeSwitch" checked>
                                <label class="form-check-label" for="activeSwitch">Active</label>
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
