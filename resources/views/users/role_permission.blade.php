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
                    <h4 class="card-title">Roles & Permissions Info</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <form method="POST" class="needs-validation" action="{{ route('users.roles-permissions.update', $user->id) }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control text-muted" 
                                    value="{{ $user->first_name . ' ' . $user->last_name }}"
                                    disabled
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input 
                                    type="email" 
                                    class="form-control text-muted" 
                                    value="{{ $user->email }}"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">                                
                                <label for="role_id" class="form-label fw-bold">Role <span class="text-danger">*</span></label>                                            
                                <select 
                                    class="form-select" 
                                    aria-label="Select roles"
                                    name="role_id[]"
                                    id="multiSelect"
                                    required
                                >
                                    @foreach($roles as $role)
                                        <option 
                                            value="{{ $role->id }}" 
                                        >
                                            {{ $role->name }}
                                        </option>
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
                                                            <input type="checkbox" name="permission_id[]" {{ in_array($group['id'], $userPermissions) ? 'checked' : '' }} value="{{ $group['id'] }}" class="me-1" /> {{ $group['name'] }}
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
    <script src="{{ asset('admin-assets/plugins/select/selectr.min.js') }}"></script>
    <script>
        let userRoles = "{{ $userRoles }}";
        let userRoless = JSON.parse(userRoles.replace(/&quot;/g, '"'));
        
        let selector = new Selectr('#multiSelect',{
                            multiple: true,
                            placeholder: 'Select Roles...',
                        });

        selector.setValue(userRoless)
    </script>
@endsection
