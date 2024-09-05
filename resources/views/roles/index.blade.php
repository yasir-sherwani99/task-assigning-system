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
                        <div class="col-lg-12">                      
                            <h4 class="card-title">Roles List</h4>             
                        </div><!--end col-->                                       
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 45%;">Name</th>
                                    <th style="width: 25%;">Slug</th>
                                    <th class="text-center" style="width: 25%;">Action</th>
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
                                            <td class="text-center">
                                                <a href="{{ route('roles.edit', $role->id) }}">
                                                    <i class="las la-pen text-secondary font-16"></i>
                                                </a>     
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