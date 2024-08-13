@extends('layouts.app')

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
                            <h4 class="card-title">Roles List</h4>             
                        </div><!--end col-->                                   
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('roles.create') }}">
                                <button type="button" class="btn btn-primary btn-sm">Add New Role</button>
                            </a>                         
                        </div><!--end col-->    
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 15%;">Name</th>
                                    <th style="width: 15%;">Slug</th>
                                    <th style="width: 50%;">Permissions</th>
                                    <th class="text-center" style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($roles) > 0)
                                    @foreach($roles as $key => $role)
                                        <tr>
                                            <td class="text-center">
                                                {{ $key + 1 }}
                                            </td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->slug }}</td>
                                            <td>
                                                <span class="badge badge-soft-primary">View Dashboard</span>
                                            </td>
                                            <td class="text-center">
                                                <form 
                                                    action="{{ route('roles.destroy', $role->id) }}" 
                                                    method="post"
                                                    onsubmit="return confirm('Are you sure?');"
                                                >                             
                                                    @csrf
                                                    @method('delete')
                                                    <a href="{{ route('roles.edit', $role->id) }}">
                                                        <i class="las la-pen text-secondary font-16"></i>
                                                    </a>
                                                    
                                                    <button type="submit" class="border-0 bg-transparent">
                                                        <i class="las la-trash-alt text-secondary font-16"></i>
                                                    </button>
                                                </form>     
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-danger">No role found!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table> 
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection