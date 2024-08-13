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
            <form method="POST" class="needs-validation" action="{{ route('clients.store') }}" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Personal Info</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
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
                            <div class="col-md-12">
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
                                <div class="invalid-feedback">
                                    Email is a required field.
                                </div>
                            </div>
                        </div>                                           
                    </div><!--end card-body-->
                </div><!--end card-->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Company Info</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="fom-group">
                                    <label for="avatar" class="form-label fw-bold">Company Logo</label>
                                    <img 
                                        src="{{ asset('admin-assets/images/users/user-vector.png') }}" 
                                        alt="babystore.ae" 
                                        class="thumb-lg rounded mx-3"
                                        id="avatar" 
                                    >
                                    <label class="btn btn-de-primary btn-sm text-light">
                                        Change Logo 
                                        <input 
                                            type="file" 
                                            hidden
                                            accept="image/*" 
                                            id="imgInp" 
                                            name="company_logo"
                                            onchange="imagePreview(event)"
                                        />
                                    </label>
                                </div>
                            </div>
                        </div><!--end form-group-->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="company_name" class="form-label fw-bold">Company Name</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="company_name" 
                                    name="company_name"
                                    placeholder="Enter company name"
                                    value="{{ old('company_name') }}"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="company_email" class="form-label fw-bold">Company Email</label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="company_email" 
                                    name="company_email"
                                    placeholder="Enter company email"
                                    value="{{ old('company_email') }}"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="company_address" class="form-label fw-bold">Company Address</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="company_address" 
                                    name="company_address"
                                    placeholder="Enter company address"
                                    value="{{ old('company_address') }}"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="company_city" class="form-label fw-bold">Company City</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="company_city" 
                                    name="company_city"
                                    placeholder="Enter company city"
                                    value="{{ old('company_city') }}"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="company_country" class="form-label fw-bold">Company Country </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="company_country" 
                                    name="company_country"
                                    placeholder="Enter company country"
                                    value="{{ old('company_country') }}"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="company_website" class="form-label fw-bold">Company Website</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="company_website" 
                                    name="company_website"
                                    placeholder="Enter company website"
                                    value="{{ old('company_website') }}"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Contact Info & Bio</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="designation" class="form-label fw-bold">Designation <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="designation" 
                                    name="designation"
                                    placeholder="Enter Designation"
                                    value="{{ old('designation') }}"
                                    required
                                />
                                <div class="invalid-feedback">
                                    Designation is a required field.
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
                                <label for="city" class="form-label fw-bold">City</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="city" 
                                    name="city"
                                    placeholder="Enter city"
                                    value="{{ old('city') }}"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label fw-bold">Country </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="country" 
                                    name="country"
                                    placeholder="Enter country"
                                    value="{{ old('country') }}"
                                />
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-check form-switch form-switch-success">
                                <input class="form-check-input" type="checkbox" name="active" id="activeSwitch" checked>
                                <label class="form-check-label" for="activeSwitch">Active</label>
                            </div>
                        </div>                                           
                    </div><!--end card-body-->
                </div><!--end card-->
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
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
