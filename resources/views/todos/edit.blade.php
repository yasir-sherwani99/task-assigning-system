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
                    <h4 class="card-title">Todo Info</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <form method="POST" class="needs-validation" action="{{ route('todos.update', $todo->id) }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="due_date" class="form-label fw-bold">Due Date <span class="text-danger">*</span></label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="due_date" 
                                    name="due_date"
                                    placeholder="Enter due date"
                                    required
                                    value="{{ $todo->due_date }}"
                                />
                                <div class="invalid-feedback">
                                    Due date is a required field.
                                </div>
                            </div>    
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control tinymce_editor"
                                    placeholder="Enter description"
                                    required
                                >{{ $todo->description }}</textarea>
                                <div class="invalid-feedback">
                                    Description is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                            <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Status"
                                    name="status"
                                    id="status"
                                    required
                                >
                                    <option value="{{ $todo->status }}">{{ ucwords($todo->status) }}</option>
                                    <option value="open">Open</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <div class="invalid-feedback">
                                    Status is a required field.
                                </div>
                            </div>
                        </div>  
                        <hr />
                        <div class="row my-3">
                            <div class="col-12 text-center">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '.tinymce_editor',
            menubar: false,
            statusbar: false,
            readonly: false,
            height: 200,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'table emoticons template paste help'
            ],
            toolbar: 'bold italic | alignleft aligncenter alignright alignjustify | ' + ' | link image media fullpage | ' +
                'bullist numlist | ' + 'emoticons',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
@endsection
