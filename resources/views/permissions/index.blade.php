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
                            <h4 class="card-title">Permissions List</h4>             
                        </div><!--end col-->                                       
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 20%;">Permission Name</th>
                                    <th style="width: 20%;">Slug</th>
                                    <th style="width: 20%;">Group</th>
                                    <th style="width: 20%;">Date</th>
                                    <th class="text-center" style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($permissions) > 0)
                                    @foreach($permissions as $key => $permission)
                                        <tr>
                                            <td class="text-center">
                                                {{ $key + 1 }}
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->slug }}</td>
                                            <td>{{ $permission->groups->name }}</td>
                                            <td>{{ $permission->created_at }}</td>
                                            <td class="text-center">     
                                                <!-- <form 
                                                    action="{{ route('permissions.destroy', $permission->id) }}" 
                                                    method="post"
                                                    onsubmit="return confirm('Are you sure?');"
                                                >                             
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="border-0 bg-transparent">
                                                        <i class="las la-trash text-secondary font-16"></i>
                                                    </button 
                                                </form> -->
                                                <a href="{{ route('permissions.edit', $permission->id) }}">
                                                    <i class="las la-pen text-secondary font-16"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-danger">No permission found!</td>
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