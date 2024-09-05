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
                    <h4 class="card-title">Meeting Info</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <form method="POST" class="needs-validation" action="{{ route('meetings.update', $meeting->id) }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="title" 
                                    name="title"
                                    placeholder="Enter event/meeting title"
                                    value="{{ $meeting->title }}"
                                    required
                                />
                                <div class="invalid-feedback">
                                    Title is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                                <input 
                                    type="datetime-local" 
                                    class="form-control" 
                                    id="start_date" 
                                    name="start_date"
                                    placeholder="Enter start date"
                                    value="{{ $meeting->start_date }}"
                                    required
                                />
                                <div class="invalid-feedback">
                                    Start date is a required field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-bold">End Date <span class="text-danger">*</span></label>
                                <input 
                                    type="datetime-local" 
                                    class="form-control" 
                                    id="end_date" 
                                    name="end_date"
                                    placeholder="Enter end date"
                                    value="{{ $meeting->end_date }}"
                                    required
                                />
                                <div class="invalid-feedback">
                                    End date is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="project_id" class="form-label fw-bold">Project</label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Project"
                                    name="project_id"
                                    id="project_id"
                                >
                                    <option value="{{ isset($meeting->projects) ? $meeting->project_id : '' }}">{{ isset($meeting->projects) ? $meeting->projects->name : 'Select Project' }}</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="client_id" class="form-label fw-bold">Client</label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Project"
                                    name="client_id"
                                    id="client_id"
                                >
                                    <option value="{{ isset($meeting->clients) ? $meeting->client_id : '' }}">{{ isset($meeting->clients) ? $meeting->clients->first_name . ' ' . $meeting->clients->last_name : 'Select Client' }}</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->first_name . ' ' . $client->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">                                
                                <label for="members" class="form-label fw-bold">Members <span class="text-danger">*</span></label>                                            
                                <select 
                                    class="form-select" 
                                    aria-label="Select Members"
                                    name="members[]"
                                    id="multiSelect"
                                    required
                                >
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Members is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="location" class="form-label fw-bold">Location</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="location" 
                                    name="location"
                                    placeholder="Enter location"
                                    value="{{ $meeting->location }}"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">Description </label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control tinymce_editor"
                                    placeholder="Enter meeting description"
                                >{{ $meeting->description }}</textarea>
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
        let meetingMembers = "{{ $meetingMembers }}";
        let meetingMemberss = JSON.parse(meetingMembers.replace(/&quot;/g, '"'));
        
        let selector = new Selectr('#multiSelect',{
                            multiple: true,
                            placeholder: 'Select Members...',
                        });

       selector.setValue(meetingMemberss)
    </script>
    <script src="{{ asset('admin-assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '.tinymce_editor',
            menubar: false,
            statusbar: false,
            readonly: false,
            height: 250,
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
